<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\BackendController;
use App\Http\Requests\UnitRequest;
use App\Models\Shop;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;

use App\Libraries\MyString;

class UnitController extends BackendController
{
    public function __construct()
    {
        parent::__construct();
        $this->data['sitetitle'] = 'Units';
        $this->middleware(['permission:unit'])->only('index');
        $this->middleware(['permission:unit_create'])->only('create', 'store');
        $this->middleware(['permission:unit_edit'])->only('edit', 'update');
        $this->middleware(['permission:unit_delete'])->only('destroy');
        $this->middleware(['permission:unit_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.unit.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();
        return view('admin.unit.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UnitRequest $request)
    {
        $unit         = new Unit;
        $unit->name   = strip_tags($request->name);
        $unit->shop_id   = $request->shop_id;
        $unit->status = $request->status;
        $unit->save();

        return redirect(route('admin.unit.index'))->withSuccess('The Data Inserted Successfully');
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
        $this->data['unit'] = Unit::findOrFail($id);
        $this->data['shops']      = Shop::where(['status' => Status::ACTIVE])->get();
        return view('admin.unit.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UnitRequest $request, $id)
    {
        $unit         = Unit::findOrFail($id);
        $unit->name   = strip_tags($request->name);
        $unit->shop_id   = $request->shop_id;
        $unit->status = $request->status;
        $unit->save();
        return redirect(route('admin.unit.index'))->withSuccess('The Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Unit::findOrFail($id)->delete();
        return redirect(route('admin.unit.index'))->withSuccess('The Data Deleted Successfully');
    }

    public function getUnit(Request $request)
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
                $units = Unit::where($queryArray)->orderBy('id', 'DESC')->get();
            } else {
                $units = Unit::orderBy('id', 'DESC')->get();
            }

            $i             = 0;
            return Datatables::of($units)
                ->addColumn('action', function ($unit) {
                    $retAction ='';

                    if(auth()->user()->can('unit_edit')) {
                        $retAction .= '<a href="' . route('admin.unit.edit', $unit) . '" class="btn btn-sm btn-icon float-left btn-primary" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="far fa-edit"></i></a>';
                    }


                    if(auth()->user()->can('unit_delete')) {
                        $retAction .= '<form class="float-left pl-2" action="' . route('admin.unit.destroy', $unit). '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"> <i class="fa fa-trash"></i></button></form>';
                    }

                    return $retAction;
                })

                ->editColumn('name', function ($unit) {
                    return Str::limit($unit->name, 50);
                })

                ->editColumn('status', function ($unit) {
                    return ($unit->status == 5 ? trans('statuses.' . Status::ACTIVE) : trans('statuses.' . Status::INACTIVE));
                })
                ->editColumn('id', function ($unit) use (&$i) {
                    return ++$i;
                })
                ->make(true);
        }
    }
}
