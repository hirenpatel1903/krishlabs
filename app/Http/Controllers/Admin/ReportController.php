<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\BackendController;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Purchaseitem;
use App\Models\Sale;
use App\Models\Saleitem;
use App\Models\Shop;
use Illuminate\Http\Request;

class ReportController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['sitetitle'] = 'Report';
    }

    public function saleReport(Request $request)
    {
        $this->data['showView']      = false;
        $this->data['set_from_date'] = '';
        $this->data['set_to_date']   = '';
        $this->data['set_to_shop_id']   = '';
        $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();

        if ($_POST) {

            $request->validate([
                'shop_id' => 'nullable',
                'from_date' => 'nullable|date',
                'to_date'   => 'nullable|date|after_or_equal:from_date',
            ]);

            $this->data['showView']      = true;
            $this->data['set_from_date'] = $request->from_date;
            $this->data['set_to_date']   = $request->to_date;
            $this->data['set_to_shop_id']   = $request->shop_id;

            $dateBetween = [];
            if ($request->from_date != '' && $request->to_date != '') {
                $dateBetween['from_date'] = date('Y-m-d', strtotime($request->from_date)) . ' 00:00:00';
                $dateBetween['to_date']   = date('Y-m-d', strtotime($request->to_date)) . ' 23:59:59';
            }

            if (!blank($dateBetween) && $request->shop_id) {
                $this->data['sales'] = Sale::where('shop_id',$request->shop_id)->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->get();
            } elseif(!blank($dateBetween)) {
                $this->data['sales'] = Sale::whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->get();
            }elseif(blank($dateBetween) && $request->shop_id) {
                $this->data['sales'] = Sale::where('shop_id',$request->shop_id)->get();
            }else{
                $this->data['sales'] = Sale::latest()->get();
            }
        }
        return view('admin.report.sale', $this->data);
    }

    public function purchaseReport(Request $request)
    {
        $this->data['showView']      = false;
        $this->data['set_from_date'] = '';
        $this->data['set_to_date']   = '';
        $this->data['set_to_shop_id']   = '';
        $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();

        if ($_POST) {

            $request->validate([
                'shop_id' => 'nullable',
                'from_date' => 'nullable|date',
                'to_date'   => 'nullable|date|after_or_equal:from_date',
            ]);

            $this->data['showView']      = true;
            $this->data['set_from_date'] = $request->from_date;
            $this->data['set_to_date']   = $request->to_date;
            $this->data['set_to_shop_id']   = $request->shop_id;

            $dateBetween = [];
            if ($request->from_date != '' && $request->to_date != '') {
                $dateBetween['from_date'] = date('Y-m-d', strtotime($request->from_date)) . ' 00:00:00';
                $dateBetween['to_date']   = date('Y-m-d', strtotime($request->to_date)) . ' 23:59:59';
            }

            if (!blank($dateBetween) && $request->shop_id) {
                $this->data['purchases'] = Purchase::where('shop_id',$request->shop_id)->whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->get();
            } elseif(!blank($dateBetween)) {
                $this->data['purchases'] = Purchase::whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->get();
            }elseif(blank($dateBetween) && $request->shop_id) {
                $this->data['purchases'] = Purchase::where('shop_id',$request->shop_id)->get();
            }else{
                $this->data['purchases'] = Purchase::latest()->get();
            }
        }
        return view('admin.report.purchase', $this->data);
    }

    public function stockReport(Request $request)
    {
        $this->data['showView']      = false;
        $this->data['set_from_date'] = '';
        $this->data['set_to_date']   = '';
        $this->data['set_to_shop_id']   = '';
        $this->data['set_to_product_id']   = '';
        $this->data['shops']         = Shop::where(['status' => Status::ACTIVE])->get();
        if(auth()->user()->myrole == 3){
            $this->data['products']      = Product::where(['status' => Status::ACTIVE,'shop_id'=>auth()->user()->shop->id])->get();
        }else{
            $this->data['products']      = Product::where(['status' => Status::ACTIVE])->get();
        }

        if ($_POST) {

            $request->validate([
                'shop_id' => 'nullable',
                'from_date' => 'nullable|date',
                'to_date'   => 'nullable|date|after_or_equal:from_date',
            ]);

            $this->data['showView']      = true;
            $this->data['set_from_date'] = $request->from_date;
            $this->data['set_to_date']   = $request->to_date;
            $this->data['set_to_shop_id']   = $request->shop_id;
            $this->data['set_to_product_id']   = $request->product_id;

            $dateBetween = [];
            if ($request->from_date != '' && $request->to_date != '') {
                $dateBetween['from_date'] = date('Y-m-d', strtotime($request->from_date)) . ' 00:00:00';
                $dateBetween['to_date']   = date('Y-m-d', strtotime($request->to_date)) . ' 23:59:59';
            }

            $queryArray = [];
            $queryProductArray = [];

            if ($request->shop_id) {
                $queryArray['shop_id'] = $request->shop_id;
                $queryProductArray['shop_id'] = $request->shop_id;
            }
            if ($request->product_id) {
                $queryArray['product_id'] = $request->product_id;
                $queryProductArray['id'] = $request->product_id;
            }
            if (!blank($queryArray) && !blank($dateBetween)) {
                $this->data['stockProducts'] = Product::where($queryProductArray)->orderBy('id', 'desc')->get();
                 $this->data['productQuantity'] = Purchaseitem::whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->where($queryArray)->groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');
                $this->data['productSaleQuantity'] = Saleitem::whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->where($queryArray)->groupBy('product_id')->selectRaw('sum(quantity) as quantity,sum(total_amount) as total_amount, product_id')->get()->keyBy('product_id');

            }elseif (!blank($queryArray)){
                $this->data['stockProducts'] = Product::where($queryProductArray)->orderBy('id', 'desc')->get();
                 $this->data['productQuantity'] = Purchaseitem::where($queryArray)->groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');
                $this->data['productSaleQuantity'] = Saleitem::where($queryArray)->groupBy('product_id')->selectRaw('sum(quantity) as quantity,sum(total_amount) as total_amount, product_id')->get()->keyBy('product_id');

            }elseif (!blank($dateBetween)){
                $this->data['stockProducts'] = Product::orderBy('id', 'desc')->get();
                 $this->data['productQuantity'] = Purchaseitem::whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');
                $this->data['productSaleQuantity'] = Saleitem::whereBetween('created_at', [$dateBetween['from_date'], $dateBetween['to_date']])->groupBy('product_id')->selectRaw('sum(quantity) as quantity,sum(total_amount) as total_amount, product_id')->get()->keyBy('product_id');

            }else{
                $this->data['stockProducts'] = Product::orderBy('id', 'desc')->get();
                $this->data['productQuantity'] = Purchaseitem::groupBy('product_id')->selectRaw('sum(quantity) as quantity, product_id')->get()->keyBy('product_id');
                $this->data['productSaleQuantity'] = Saleitem::groupBy('product_id')->selectRaw('sum(quantity) as quantity,sum(total_amount) as total_amount, product_id')->get()->keyBy('product_id');
            }
        }
        return view('admin.report.stock', $this->data);
    }





}
