<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProductRequested;
use App\Enums\ProductStatus;
use App\Enums\ProductType;
use App\Enums\Status;
use App\Http\Controllers\BackendController;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductItem;
use App\Models\Shop;
use App\Models\Tax;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class ProductController extends BackendController
{

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Products';

        $this->middleware(['permission:products'])->only('index');
        $this->middleware(['permission:products_create'])->only('create', 'store');
        $this->middleware(['permission:products_edit'])->only('edit', 'update');
        $this->middleware(['permission:products_delete'])->only('destroy');
        $this->middleware(['permission:products_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->myrole == 3){
            $this->data['categories'] = Category::where(['shop_id'=>auth()->user()->shop->id,'status' => Status::ACTIVE])->get();
            $this->data['units']      = Unit::where(['shop_id'=>auth()->user()->shop->id,'status' => Status::ACTIVE])->get();
            $this->data['taxs']      = Tax::where(['shop_id'=>auth()->user()->shop->id,'status' => Status::ACTIVE])->get();
        }else{
            $this->data['categories'] = Category::where(['status' => Status::ACTIVE])->get();
            $this->data['units']      = Unit::where(['status' => Status::ACTIVE])->get();
            $this->data['taxs']      = Tax::where(['status' => Status::ACTIVE])->get();
        }

        $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();
        return view('admin.product.create', $this->data);
    }

    /**
     * @param ProductRequest $request
     * @return mixed
     */
    public function store(ProductRequest $request)
    {
        $product              = new Product;
        $product->name        = strip_tags($request->get('name'));
        $product->slug        = str_replace(' ', '-', strtolower(strip_tags($request->get('name'))));
        $product->description = strip_tags($request->get('description'));
        $product->status      = strip_tags($request->get('status'));
        $product->price       = strip_tags($request->get('price'));
        $product->cost        = strip_tags($request->get('cost'));
        $product->unit_id     = $request->get('unit');
        $product->tax_id     = $request->get('tax_id');
        $product->shop_id     = $request->get('shop_id');
        $product->barcode     = strip_tags($request->get('barcode'));
        $product->barcode_type = $request->get('barcode_type');
        $product->type          = $request->get('variant') == true ? ProductType::VARIATION:ProductType::SINGLE;
        $product->save();
        $product->categories()->sync($request->get('categories'));
        $product->barcode = strip_tags($request->get('barcode')).$product->id;
        $product->save();


        if (!blank(request()->variation)) {
            $productVariationArray = [];
            $i = 0;
            foreach ($request->variation as $variation) {
                $productVariationArray[$i]['product_id'] = $product->id;
                $productVariationArray[$i]['shop_id'] = $request->get('shop_id');
                $productVariationArray[$i]['name'] = strip_tags($variation['name']);
                $productVariationArray[$i]['price'] = strip_tags($variation['price']);
                $i++;
            }
            ProductItem::insert($productVariationArray);
        }

        //Store Image
        if (request()->file('image')) {
            $product->media()->delete();
            $product->addMedia(request()->file('image'))->toMediaCollection('products');
        }


        return redirect()->route('admin.products.index')->withSuccess('The data inserted successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        if(auth()->user()->myrole == 3){
            $this->data['categories'] = Category::where(['shop_id'=>auth()->user()->shop->id,'status' => Status::ACTIVE])->get();
            $this->data['units']      = Unit::where(['shop_id'=>auth()->user()->shop->id,'status' => Status::ACTIVE])->get();
            $this->data['taxs']      = Tax::where(['shop_id'=>auth()->user()->shop->id,'status' => Status::ACTIVE])->get();
        }else{
            $this->data['categories'] = Category::where(['shop_id'=>$product->shop_id,'status' => Status::ACTIVE])->get();
            $this->data['units']      = Unit::where(['shop_id'=>$product->shop_id,'status' => Status::ACTIVE])->get();
            $this->data['taxs']      = Tax::where(['shop_id'=>$product->shop_id,'status' => Status::ACTIVE])->get();
        }
        $this->data['product']            = $product;
        $this->data['product_categories'] = $product->categories()->pluck('id')->toArray();
        $this->data['product_variations'] = $product->variations;
        $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();

        return view('admin.product.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param ProductRequest $request
     * @param $id
     * @return mixed
     */
    public function update(ProductRequest $request, $id)
    {

        $product              = Product::findOrFail($id);
        $product->name        = strip_tags($request->get('name'));
        $product->slug        = str_replace(' ', '-', strtolower(strip_tags($request->get('name'))));
        $product->description = strip_tags($request->get('description'));
        $product->status      = strip_tags($request->get('status'));
        $product->price       = $request->get('price');
        $product->cost        = $request->get('cost');
        $product->unit_id     = $request->get('unit');
        $product->tax_id     = $request->get('tax_id');
        $product->shop_id     = $request->get('shop_id');
        $product->barcode     = strip_tags($request->get('barcode'));
        $product->barcode_type = $request->get('barcode_type');
        $product->type          = $request->get('variant') == true ? ProductType::VARIATION:ProductType::SINGLE;
        $product->save();
        $product->categories()->sync($request->get('categories'));


        if (!blank(request()->variation)) {
            $productVariation = ProductItem::where([
                'shop_id'    => $request->get('shop_id'),
                'product_id' => $product->id,
            ])->get()->pluck('id', 'id')->toArray();

            foreach ($request->variation  as $key => $variation) {
                if (isset($productVariation[$key])) {
                    $productVariationItem = ProductItem::where([
                        'shop_id'    => $request->get('shop_id'),
                        'product_id' => $product->id,
                        'id'         => $key,
                    ])->first();
                    $productVariationItem->product_id      = $product->id;
                    $productVariationItem->shop_id         = $request->get('shop_id');
                    $productVariationItem->name            = $variation['name'];
                    $productVariationItem->price           = $variation['price'];
                    $productVariationItem->save();
                } else {
                    $productVariationArray['product_id'] = $product->id;
                    $productVariationArray['shop_id'] = $request->get('shop_id');
                    $productVariationArray['name'] = $variation['name'];
                    $productVariationArray['price'] = $variation['price'];

                    ProductItem::insert($productVariationArray);
                }
            }
        }

        return redirect()->route('admin.products.index')->withSuccess('The data updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $product = Product::findOrFail($id);
       if(!blank($product->variations)){
           foreach ($product->variations as $variation){
               $variation->delete();
           }
       }
        $product->delete();

        return redirect()->route('admin.products.index')->withSuccess('The Data Deleted Successfully');
    }

    public function getProduct(Request $request)
    {
        if (request()->ajax()) {

            $queryArray = [];
            if (!empty($request->status) && (int) $request->status) {
                $queryArray['status'] = $request->status;
            }
            if ($request->requested != '') {
                $queryArray['requested'] = $request->requested;
            }
            if (auth()->user()->myrole == 3) {
                $queryArray['shop_id'] = auth()->user()->shop->id;
            }

            if (!blank($queryArray)){
                $products = Product::with('categories')->where($queryArray)->latest()->get();
            } else {
                $products = Product::with('categories')->latest()->get();
            }

            $i            = 1;
            $productArray = [];
            if (!blank($products)) {
                foreach ($products as $product) {
                    $productArray[$i]          = $product;
                    $productArray[$i]['setID'] = $i;
                    $i++;
                }
            }
            return Datatables::of($productArray)
                ->addColumn('action', function ($product) {
                    $retAction ='';

                    if(auth()->user()->can('products_show')) {
                        $retAction .= '<a href="' . route('admin.products.show', $product) . '" class="btn btn-sm btn-icon mr-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }

                    if(auth()->user()->can('products_edit')) {
                        $retAction .= '<a href="' . route('admin.products.edit', $product) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                    }


                    if(auth()->user()->can('products_delete')) {
                        $retAction .= '<form class="float-left pl-2" action="' . route('admin.products.destroy', $product). '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i></button></form>';
                    }

                    return $retAction;
                })
                ->editColumn('categories', function ($product) {
                    $categories = implode(', ', $product->categories()->pluck('name')->toArray());
                    if($categories){
                        return Str::limit($categories, 30);
                    }else{
                        return 'N/A';
                    }
                })
                ->editColumn('name', function ($product) {
                    $col = '<p class="p-0 m-0">' . Str::limit($product->name, 20) . '</p>';
                    $col .= '<small class="text-muted">' . Str::limit($product->description, 20) . '</small>';
                    return $col;
                })
                ->editColumn('unit', function ($product) {

                    return optional($product->unit)->name;
                })
                ->editColumn('cost', function ($product) {
                    return currencyFormat($product->cost);
                })->editColumn('price', function ($product) {
                    return currencyFormat($product->price);
                })->editColumn('status', function ($product) {
                    return ($product->status == 5 ? trans('statuses.' . Status::ACTIVE) : trans('statuses.' . Status::INACTIVE));
                })
                ->editColumn('created_at', function ($product) {
                    return $product->created_at->diffForHumans();
                })
                ->editColumn('id', function ($product) {
                    return $product->setID;
                })
                ->rawColumns(['name', 'action'])
                ->make(true);
        }
    }


    public function barcode( Request $request)
    {
        $this->data['showView']    = false;
        $this->data['set_product_id'] = '';
        $this->data['set_variant_id'] = '';
        $this->data['set_quantity'] = '';
        if(isset(auth()->user()->shop)){
            $this->data['products']      = Product::where(['shop_id'=>auth()->user()->shop->id, 'status' => Status::ACTIVE])->get();
        }else{
            $this->data['products']      = Product::where(['status' => Status::ACTIVE])->get();
        }
        $this->data['variants'] = [];

        if ( $_POST ) {
            $request->validate([
                'product_id' => 'nullable|numeric',
            ]);
            $this->data['showView'] = true;
            $this->data['set_product_id'] = $request->product_id;
            $this->data['set_variant_id'] = $request->variant_id;
            $this->data['set_quantity'] = $request->quantity;
            $this->data['variants'] = ProductItem::where(['product_id'=>$request->product_id])->get();


            $this->data['productBarcode']      = Product::where(['id'=>$request->product_id,'status' => Status::ACTIVE])->first();
            $this->data['productVariant']      = ProductItem::where(['id'=>$request->variant_id,'product_id'=>$request->product_id])->first();
        }
        return view('admin.product.barcode', $this->data);
    }

    public function getVariants( Request $request )
    {
        $product_id = $request->get('product');
        if ( ((int)$product_id) ) {
            $ProductItems     = ProductItem::where(['product_id'=>$product_id])->latest()->get();
            if ( !blank($ProductItems) ) {
                foreach ( $ProductItems as $ProductItem ) {
                 echo "<option value='" . $ProductItem->id . "'>" . $ProductItem->name .' '.'('.$ProductItem->price.')'. "</option>";
                }
            }
        }
    }

    public function getUnit( Request $request )
    {
        $shop_id = $request->get('shop_id');
        if ( ((int)$shop_id) ) {
            $units     = Unit::where(['shop_id'=>$shop_id,'status' => Status::ACTIVE])->get();
            echo '<option value="0">'.__('Select Unit').'</option>';
            if ( !blank($units) ) {
                foreach ( $units as $unit ) {
                    echo "<option value='" . $unit->id . "'>" . $unit->name. "</option>";
                }
            }
        }
    }

    public function getTax( Request $request )
    {
        $shop_id = $request->get('shop_id');
        if ( ((int)$shop_id) ) {
            $taxs     = Tax::where(['shop_id'=>$shop_id,'status' => Status::ACTIVE])->get();
            echo '<option value="0">'.__('Select Tax Rate').'</option>';
            if ( !blank($taxs) ) {
                foreach ( $taxs as $tax ) {
                    echo "<option value='" . $tax->id . "'>" . $tax->name. "</option>";
                }
            }
        }
    }

    public function getCategory( Request $request )
    {
        $shop_id = $request->get('shop_id');
        if ( ((int)$shop_id) ) {
            $categories     = Category::where(['shop_id'=>$shop_id,'status' => Status::ACTIVE])->get();
            if ( !blank($categories) ) {
                foreach ( $categories as $category ) {
                    echo "<option value='" . $category->id . "'>" . $category->name. "</option>";
                }
            }
        }
    }





}
