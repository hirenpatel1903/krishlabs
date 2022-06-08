<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\BackendController;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\Purchase;
use App\Models\Purchaseitem;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class PurchaseController extends BackendController
{

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['sitetitle'] = 'Purchases';
        $this->middleware(['permission:purchase'])->only('index');
        $this->middleware(['permission:purchase_create'])->only('create', 'store');
        $this->middleware(['permission:purchase_edit'])->only('edit', 'update');
        $this->middleware(['permission:purchase_delete'])->only('destroy');
        $this->middleware(['permission:purchase_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.purchase.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->myrole == 3){
            $this->data['products']      = Product::where(['shop_id'=>auth()->user()->shop->id,'status' => Status::ACTIVE])->get();
        }else{
            $this->data['products']   = Product::where(['status' => Status::ACTIVE])->get();

        }
        $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();

        $this->data['productobj'] =  Product::latest()->get(['name','barcode','price','cost', 'id'])->keyBy('id');

        return view('admin.purchase.create', $this->data);
    }

    /**
     * @param ProductRequest $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $retArray['status']  = false;
        $retArray['message'] = '';

        $validator = new PurchaseRequest;
        $validator = Validator::make($request->all(), $validator->rules());

        if (!$validator->fails()) {

            $purchase = new Purchase;

            $purchase->shop_id  = $request->shop_id;
            $purchase->purchases_no  = strip_tags($request->purchases_no);
            $purchase->description  = strip_tags($request->description);
            $purchase->date        = date('Y-m-d', strtotime($request->date));
            $purchase->sub_total       = 0;
            $purchase->save();

            $items = json_decode($request->productitem);
            if (!blank($items)) {
                $itemArray = [];
                $i         = 0;
                $amount    = 0;
                foreach ($items as $item) {
                    $itemArray[$i]['shop_id'] = $request->shop_id;
                    $itemArray[$i]['purchase_id'] = $purchase->id;
                    $itemArray[$i]['product_id']  = $item->productID;
                    $itemArray[$i]['product_item_id']  = $item->variantID ??0;
                    $itemArray[$i]['unit_price']  = $item->price;
                    $itemArray[$i]['quantity']    = $item->quantity;
                    $itemArray[$i]['created_at']  = date('Y-m-d H:i:s');
                    $itemArray[$i]['updated_at']  = date('Y-m-d H:i:s');

                    $amount += ($itemArray[$i]['unit_price'] * $itemArray[$i]['quantity']);

                    $i++;
                }
                Purchaseitem::insert($itemArray);
                $purchase->sub_total = $amount;
                $purchase->save();
            }

            $retArray['status']  = true;
            $retArray['message'] = 'The product purchase successfully completed.';
        } else {
            $retArray['message'] = $validator->errors();
        }

        if ($retArray['status']) {
            $request->session()->flash('success', $retArray['message']);
        } else {
            $request->session()->flash('error', $retArray['message']);
        }

        echo json_encode($retArray);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Purchase $purchase)
    {
        $this->data['purchase'] = $purchase;
        return view('admin.purchase.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Purchase $purchase)
    {
        if(auth()->user()->myrole == 3){
            $this->data['products']      = Product::where(['shop_id'=>auth()->user()->shop->id,'status' => Status::ACTIVE])->get();
        }else{
            $this->data['products']   = Product::where(['status' => Status::ACTIVE])->get();

        }
        $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();
        $this->data['purchase']   = $purchase;
        if(auth()->user()->myrole == 3){
            $this->data['productobj']      = Product::where(['shop_id'=>auth()->user()->shop->id,'status' => Status::ACTIVE])->get(['name','barcode','price','cost', 'id'])->keyBy('id');
        }else{
            $this->data['productobj'] = Product::latest()->get(['name','barcode','price','cost', 'id'])->keyBy('id');
        }
        $this->data['productPurchase'] =  Purchaseitem::orderBy('id', 'asc')->get(['unit_price','product_item_id', 'product_id'])->keyBy('product_id');

        return view('admin.purchase.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param ProductRequest $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $retArray['status']  = false;
        $retArray['message'] = '';

        $validator = new PurchaseRequest;
        $validator = Validator::make($request->all(), $validator->rules());

        if (!$validator->fails()) {

            $purchase = Purchase::find($id);
            if (!blank($purchase)) {

                $purchase->shop_id  = $request->shop_id;
                $purchase->purchases_no  = strip_tags($request->purchases_no);
                $purchase->description  = strip_tags($request->description);
                $purchase->date        = date('Y-m-d', strtotime($request->date));
                $purchase->sub_total       = 0;
                $purchase->save();

                $items = json_decode($request->productitem);
                if (!blank($items)) {
                    $itemArray = [];
                    $i         = 0;
                    $amount    = 0;
                    foreach ($items as $item) {
                        $itemArray[$i]['shop_id'] = $request->shop_id;
                        $itemArray[$i]['purchase_id'] = $purchase->id;
                        $itemArray[$i]['product_id']  = $item->productID;
                        $itemArray[$i]['product_item_id']  = $item->variantID ??0;
                        $itemArray[$i]['unit_price']  = $item->price;
                        $itemArray[$i]['quantity']    = $item->quantity;
                        $itemArray[$i]['created_at']  = date('Y-m-d H:i:s');
                        $itemArray[$i]['updated_at']  = date('Y-m-d H:i:s');

                        $amount += ($itemArray[$i]['unit_price'] * $itemArray[$i]['quantity']);

                        $i++;
                    }
                    Purchaseitem::where(['purchase_id' => $id])->delete();

                    Purchaseitem::insert($itemArray);

                    $purchase->sub_total = $amount;
                    $purchase->save();
                }
                $retArray['status']  = true;
                $retArray['message'] = 'The product purchase successfully completed.';
            } else {
                $retArray['message'] = 'The purchase item not found.';
            }
        } else {
            $retArray['message'] = $validator->errors();
        }

        if ($retArray['status']) {
            $request->session()->flash('success', $retArray['message']);
        } else {
            $request->session()->flash('error', $retArray['message']);
        }

        echo json_encode($retArray);
        return redirect()->route('admin.purchase.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->items()->delete();
        $purchase->delete();
        return redirect()->route('admin.purchase.index')->withSuccess('The Data Deleted Successfully');
    }

    public function getPurchase(Request $request)
    {
        if (request()->ajax()) {
            if(auth()->user()->myrole == 3){
                $purchases = Purchase::where('shop_id',auth()->user()->shop->id)->orderBy('id', 'desc')->get();

            }else{
                $purchases = Purchase::orderBy('id', 'desc')->get();
            }

            $i             = 0;
            return Datatables::of($purchases)
                ->addColumn('action', function ($purchase) {
                    $retAction ='';

                    if(auth()->user()->can('purchase_show')) {
                        $retAction .= '<a href="' . route('admin.purchase.show', $purchase) . '" class="btn btn-sm btn-icon mr-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }

                    if(auth()->user()->can('purchase_edit')) {
                        $retAction .= '<a href="' . route('admin.purchase.edit', $purchase) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                    }


                    if(auth()->user()->can('purchase_delete')) {
                        $retAction .= '<form class="float-left pl-2" action="' . route('admin.purchase.destroy', $purchase). '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i></button></form>';
                    }

                    return $retAction;
                })

                ->editColumn('status', function ($purchase) {
                    if($purchase->status == 0) {
                        return "Paid";
                    } else if($purchase->status == 1) {
                        return "Pending";
                    } else if($purchase->status == 2) {
                        return "Partial Paid";
                    }else if($purchase->status == 3) {
                        return "Fully Paid";
                    }
                })
                ->editColumn('date', function ($purchase) {
                    return date('d M Y', strtotime($purchase->date));
                })
                ->editColumn('purchases_no', function ($purchase) {
                    return strip_tags(htmlspecialchars_decode($purchase->purchases_no));
                })
                ->editColumn('shop_id', function ($purchase) {
                    return optional($purchase->shop)->name;
                })
                ->editColumn('id', function ($purchase) use ($i){
                    return $i+1;
                })
                ->rawColumns(['name', 'action'])
                ->escapeColumns([])
                ->make(true);
        }
    }

    public function getVariants( Request $request )
    {
        $product_id = $request->get('product');
        $productvariantID = $request->get('productvariantID');
        if ( ((int)$product_id) ) {
            $ProductItems     = ProductItem::where(['product_id'=>$product_id])->latest()->get();
            if ( !blank($ProductItems) ) {
                foreach ( $ProductItems as $ProductItem ) {
                    if($productvariantID !=0){
                        if($productvariantID == $ProductItem->id){
                            echo "<option value='".$ProductItem->id ."' selected>" . $ProductItem->name ."</option>";
                        }else{
                            echo "<option value='" . $ProductItem->id . "'>" . $ProductItem->name ."</option>";
                        }
                    }else {
                        echo "<option value='" . $ProductItem->id . "'>" . $ProductItem->name ."</option>";
                    }
                }
            }
        }
    }

    public function getShopProduct( Request $request )
    {
        $shop_id = $request->get('shopID');
        if ( ((int)$shop_id) ) {
            $products     = Product::where(['shop_id'=>$shop_id])->latest()->get();
            echo '<option value="0">'.__('Select Product').'</option>';
            if ( !blank($products) ) {
                foreach ( $products as $ProductItem ) {
                    if($ProductItem->type == 10 && !blank($ProductItem->variations)){
                        echo "<option value='" . $ProductItem->id . "' data-product-type='".$ProductItem->type."' data-variant='".$ProductItem->variations[0]->id."'>" .$ProductItem->barcode.$ProductItem->variations[0]->id.'-'.$ProductItem->name.'('.$ProductItem->variations[0]->name.')' ."</option>";
                    }else{
                        echo "<option value='" . $ProductItem->id . "' data-product-type='".$ProductItem->type."' data-variant=''>" . $ProductItem->barcode.'-'.$ProductItem->name ."</option>";
                    }
                }
            }
        }
    }
}
