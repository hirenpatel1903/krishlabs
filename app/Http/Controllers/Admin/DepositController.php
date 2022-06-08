<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Http\Requests\DepositRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Services\DepositService;
use App\Models\Deposit;
use App\Models\User;
use App\Notifications\DepositCreated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class DepositController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle']      = 'Deposit';

        $this->middleware(['permission:deposit'])->only('index');
        $this->middleware(['permission:deposit_create'])->only('create', 'store');
        $this->middleware(['permission:deposit_edit'])->only('edit', 'update');
        $this->middleware(['permission:deposit_delete'])->only('destroy');
        $this->middleware(['permission:deposit_show'])->only('show', 'savePermission');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.deposit.index', $this->data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role                      = Role::find(2);
        $this->data['users']     = User::role($role->name)->latest()->get();

        return view('admin.deposit.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepositRequest $request)
    {
        $deposit            = new Deposit;
        $deposit->user_id   = $request->user_id;
        $deposit->amount    = $request->amount;
        $deposit->save();

        $depositAmount = $request->amount;
        if(blank($depositAmount)) {
            $depositAmount = 0;
        }
        $depositService = app(DepositService::class)->depositAdjust($deposit->user_id, $deposit->user->balance_id,$depositAmount);
        if(setting('twilio_disabled') || setting('wati_disabled')){
            try {
                $deposit->user->notify(new DepositCreated($deposit));

            }catch (\Exception $exception){
                //
            }
        }
        return redirect(route('admin.deposit.index'))->withSuccess('The Data Inserted Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role                      = Role::find(2);
        $this->data['users']     = User::role($role->name)->latest()->get();
        $this->data['deposit'] = Deposit::findOrFail($id);
        return view('admin.deposit.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepositRequest $request, $id)
    {
        $deposit       = Deposit::findOrFail($id);
        $deposit->user_id   = $request->user_id;
        $deposit->amount    = $request->amount;
        $deposit->save();

        $depositAmount = $request->amount;
        if(blank($depositAmount)) {
            $depositAmount = 0;
        }
        $depositService = app(DepositService::class)->depositAdjust($deposit->user_id, $deposit->user->balance_id,$depositAmount);
        if(setting('twilio_disabled') || setting('wati_disabled')){
            try {
                $deposit->user->notify(new DepositCreated($deposit));

            }catch (\Exception $exception){
                //
            }
        }
        return redirect(route('admin.deposit.index'))->withSuccess('The Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

            Deposit::findOrFail($id)->delete();
            return redirect(route('admin.deposit.index'))->withSuccess('The Data Deleted Successfully');

    }

    public function getDeposit()
    {
        $deposits     = Deposit::orderBy('id', 'desc')->get();
        $depositArray = [];

        $i = 1;
        if (!blank($deposits)) {
            foreach ($deposits as $deposit) {
                $depositArray[$i]          = $deposit;
                $depositArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($depositArray)
            ->addColumn('action', function ($deposit) {
                $retAction = '';

                if (auth()->user()->can('deposit_edit')) {
                    $retAction .= '<a href="' . route('admin.deposit.edit', $deposit) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                }

                if(auth()->user()->can('deposit_delete')) {
                    $retAction .='<form class="float-left pl-2" action="' . route('admin.deposit.destroy', $deposit) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></form>';
                }

                return $retAction;
            })
            ->addColumn('image', function ($deposit) {
                return '<figure class="avatar mr-2"><img src="' . optional($deposit->user)->images . '" alt=""></figure>';
            })
            ->addColumn('name', function ($deposit) {
                return optional($deposit->user)->name;
            })
            ->addColumn('credit', function ($deposit) {
                return currencyFormat($deposit->amount);
            })
            ->addColumn('date', function ($deposit) {
                return Carbon::parse($deposit->created_at)->format('d M Y, h:i A');
            })
            ->editColumn('id', function ($deposit) {
                return $deposit->setID;
            })
            ->escapeColumns([])
            ->make(true);
    }


}
