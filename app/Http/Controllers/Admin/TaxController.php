<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Enums\TaxType;
use App\Http\Controllers\BackendController;
use App\Http\Requests\TaxRequest;
use App\Models\Shop;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

use App\Libraries\MyString;

class TaxController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['sitetitle'] = 'Tax Rates';
        $this->middleware(['permission:tax'])->only('index');
        $this->middleware(['permission:tax_create'])->only('create', 'store');
        $this->middleware(['permission:tax_edit'])->only('edit', 'update');
        $this->middleware(['permission:tax_delete'])->only('destroy');
        $this->middleware(['permission:tax_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tax.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();
        return view('admin.tax.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaxRequest $request)
    {
        $tax         = new Tax;
        $tax->name   = strip_tags($request->name);
        $tax->code   = strip_tags($request->code);
        $tax->tax_rate   = $request->tax_rate;
        $tax->type   = $request->type;
        $tax->shop_id   = $request->shop_id;
        $tax->status = $request->status;
        $tax->save();

        return redirect(route('admin.tax.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['tax'] = Tax::findOrFail($id);
        $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();
        return view('admin.tax.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaxRequest $request, $id)
    {
        $tax         = Tax::findOrFail($id);
        $tax->name   = strip_tags($request->name);
        $tax->code   = strip_tags($request->code);
        $tax->tax_rate   = $request->tax_rate;
        $tax->type   = $request->type;
        $tax->shop_id   = $request->shop_id;
        $tax->status = $request->status;
        $tax->save();
        return redirect(route('admin.tax.index'))->withSuccess('The Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tax::findOrFail($id)->delete();
        return redirect(route('admin.tax.index'))->withSuccess('The Data Deleted Successfully');
    }

    public function getTax(Request $request)
    {
        if (request()->ajax()) {
            $queryArray = [];
            if (!empty($request->status) && (int) $request->status) {
                $queryArray['status'] = $request->status;
            }
            if (auth()->user()->myrole == 3) {
                $queryArray['shop_id'] = auth()->user()->shop->id;
            }

            if (!blank($queryArray)) {
                $taxs = Tax::where($queryArray)->orderBy('id', 'DESC')->get();
            } else {
                $taxs = Tax::orderBy('id', 'DESC')->get();
            }

            $i             = 0;
            return Datatables::of($taxs)
                ->addColumn('action', function ($tax) {
                    $retAction ='';

                    if(auth()->user()->can('tax_edit')) {
                        $retAction .= '<a href="' . route('admin.tax.edit', $tax) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                    }


                    if(auth()->user()->can('tax_delete')) {
                        $retAction .= '<form class="float-left pl-2" action="' . route('admin.tax.destroy', $tax). '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i></button></form>';
                    }

                    return $retAction;
                })

                ->editColumn('name', function ($tax) {
                    return Str::limit($tax->name, 50);
                })

                ->editColumn('code', function ($tax) {
                    return Str::limit($tax->code, 50);
                })
                ->editColumn('tax_rate', function ($tax) {
                    return number_format($tax->tax_rate,2);
                })

                ->editColumn('type', function ($tax) {
                    return ($tax->type == 5 ? trans('taxtype.' . TaxType::FIXED) : trans('taxtype.' . TaxType::PERCENTAGE));
                })

                ->editColumn('status', function ($tax) {
                    return ($tax->status == 5 ? trans('statuses.' . Status::ACTIVE) : trans('statuses.' . Status::INACTIVE));
                })
                ->editColumn('id', function ($tax) use (&$i) {
                    return ++$i;
                })
                ->make(true);
        }
    }
}
