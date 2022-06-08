<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\BackendController;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Purchaseitem;
use App\Models\Saleitem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

class StockController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['sitetitle'] = 'Stocks';
        $this->middleware(['permission:stock'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.stock.index', $this->data);
    }

    public function getStock(Request $request)
    {
        if (request()->ajax()) {
            $queryArray = [];

            if (auth()->user()->myrole == 3) {
                $queryArray['shop_id'] = auth()->user()->shop->id;
            }
            if (!blank($queryArray)) {
                $products = Product::where($queryArray)->orderBy('id', 'desc')->get();
                $productQuantity = Purchaseitem::where($queryArray)->groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');
                $productSaleQuantity = Saleitem::where($queryArray)->groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');

            }else{
                $products = Product::orderBy('id', 'desc')->get();
                $productQuantity = Purchaseitem::groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');
                $productSaleQuantity = Saleitem::groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');

            }

            $i         = 1;
            $productArray = [];
            if (!blank($products)) {
                foreach ($products as $product) {
                    $productArray[$i]          = $product;
                    $productArray[$i]['product']  = Str::limit($product->name, 150);
                    $productArray[$i]['unit']  = Str::limit(optional($product->unit)->name, 30);
                    $productArray[$i]['setID'] = $i;
                    $productArray[$i]['Salequantity'] = isset($productSaleQuantity[$product->id]) ? $productSaleQuantity[$product->id]->quantity: '0';
                    $productArray[$i]['Totalquantity'] = isset($productQuantity[$product->id]) ? $productQuantity[$product->id]->quantity: '0';
                    $i++;
                }
            }
            return Datatables::of($productArray)
                ->editColumn('unit', function ($product) {
                    return $product->unit;
                })
                ->editColumn('sale_qty', function ($product) {
                    return $product->Salequantity;
                })
                ->editColumn('total_qty', function ($product) {
                    return $product->Totalquantity;
                })
                ->editColumn('stock_qty', function ($product) {
                    $value = ($product->Totalquantity) - ($product->Salequantity);
                    if($value == 0){
                        $col ='<p class="p-0 m-0 text-danger">' .$value. '</p>';
                    }else{
                        $col ='<p class="p-0 m-0">' . $value. '</p>';
                    }
                    return $col;
                })

                ->editColumn('id', function ($product) {
                    return $product->setID;
                })
                ->escapeColumns([])
                ->make(true);
        }
    }
}
