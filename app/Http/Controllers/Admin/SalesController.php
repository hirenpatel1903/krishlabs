<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\Shop;
use App\Models\User;
use App\Enums\Status;
use App\Models\Product;
use App\Helpers\Support;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Enums\ProductStatus;
use App\Models\Purchaseitem;
use Illuminate\Http\Request;
use App\Enums\ProductRequested;
use Yajra\Datatables\Datatables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\BackendController;

class SalesController extends BackendController
{

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Sales';

        $this->middleware(['permission:sale'])->only('index');
        $this->middleware(['permission:pos'])->only('create', 'store');
        $this->middleware(['permission:sale_edit'])->only('edit', 'update');
        $this->middleware(['permission:sale_delete'])->only('destroy');
        $this->middleware(['permission:sale_show'])->only('show', 'posPrint');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sale.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Support::checking()->status) {

            $role                      = Role::find(2);
            $this->data['customers']     = User::role($role->name)->latest()->get();

            if (auth()->user()->myrole == 3) {

                return view('admin.sale.create', $this->data);
            } else {
                if (!blank(session()->get('shop_id'))) {

                    return view('admin.sale.create', $this->data);
                } else {
                    $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();

                    return view('admin.sale.shop', $this->data);
                }
            }
        } else {
            return redirect(route('admin.setting.purchasekey'))->withError('Invalid Envato Username and Purchase code.');
        }
    }


    public function shop(Request $request)
    {
        $this->validate($request, [
            'shop_id' => 'required',
        ]);

        session()->forget('shop_id');
        if (!blank((int)$request->shop_id)) {
            session()->put('shop_id', $request->shop_id);
            return redirect()->route('admin.pos');
        }
    }

    public function changeShop(Request $request)
    {
        session()->forget('shop_id');
        return redirect()->route('admin.pos');
    }

    /**
     * @param ProductRequest $request
     * @return mixed
     */
    public function store(ProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Product $sale
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Sale $sale)
    {
        return view('admin.sale.show', compact('sale'));
    }



    public function posPrint(Sale $sale)
    {
        return view('admin.sale.print', compact('sale'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $sale
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Sale $sale)
    {
    }

    /**
     * Update the specified resource in storage.
     * @param ProductRequest $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->items()->delete();
        $sale->delete();

        return redirect()->route('admin.sale.index')->withSuccess('The Data Deleted Successfully');
    }

    public function getSales(Request $request)
    {

        if (auth()->user()->myrole == 3) {
            $sales = Sale::where('shop_id', auth()->user()->shop->id)->orderBy('id', 'desc')->latest()->get();
        } else {
            $sales = Sale::orderBy('id', 'desc')->latest()->get();
        }

        $i            = 1;
        $salesArray = [];
        if (!blank($sales)) {
            foreach ($sales as $sale) {
                $salesArray[$i]          = $sale;
                $salesArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($salesArray)

            ->addColumn('action', function ($sale) {
                $retAction = '';
                if (auth()->user()->can('sale_show')) {
                    $retAction .= '<a href="' . route('admin.sale.show', $sale) . '" class="btn btn-sm btn-icon mr-2  float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }

                if (auth()->user()->can('sale_delete')) {
                    $retAction .= '<a data-toggle="modal" data-url="' . route('admin.sale.destroy', $sale) . '" data-id="' . $sale . '" data-target="#custom-width-modal" class="btn btn-sm btn-icon ml-2 btn-danger  remove-record" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash text-white"></i></a>';
                }
                return $retAction;
            })

            ->editColumn('date', function ($sale) {
                return date('d M Y', strtotime($sale->created_at));
            })
            ->editColumn('sale_no', function ($sale) {
                return $sale->sale_no;
            })
            ->editColumn('customer_id', function ($sale) {
                return optional($sale->user)->name;
            })

            ->editColumn('sub_total', function ($sale) {
                $total = $sale->sub_total + $sale->tax_amount;
                return number_format($total, 2);
            })

            ->editColumn('paid', function ($sale) {
                return currencyFormat($sale->paid_amount);
            })
            ->editColumn('id', function ($sale) {
                return $sale->setID;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
