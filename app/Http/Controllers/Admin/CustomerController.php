<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BackendController;
use App\Http\Requests\CustomerRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;

class CustomerController extends BackendController
{
    public function __construct()
    {
        $this->data['siteTitle'] = 'Customers';

        $this->middleware(['permission:customers'])->only('index');
        $this->middleware(['permission:customers_create'])->only('create', 'store');
        $this->middleware(['permission:customers_edit'])->only('edit', 'update');
        $this->middleware(['permission:customers_delete'])->only('destroy');
        $this->middleware(['permission:customers_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.customer.index', $this->data);
    }

    public function create()
    {
        return view('admin.customer.create', $this->data);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find(2);
        $this->data['user'] = User::role($role->name)->findOrFail($id);
        return view('admin.customer.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find(2);
        $this->data['user'] = User::role($role->name)->findOrFail($id);
        return view('admin.customer.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(){}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->deposits()->delete();
        $user->delete();
        return redirect(route('admin.customers.index'))->withSuccess('The Data Deleted Successfully');
    }

    public function getCustomers()
    {
        $role      = Role::find(2);
        $users     = User::role($role->name)->latest()->get();
        $userArray = [];

        $i = 1;
        if (!blank($users)) {
            foreach ($users as $user) {
                $userArray[$i]          = $user;
                $userArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($userArray)
            ->addColumn('action', function ($user) {
                $retAction = '';

                if (auth()->user()->can('customers_show')) {
                    $retAction .= '<a href="' . route('admin.customers.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                }

                if (auth()->user()->can('customers_edit')) {
                    $retAction .= '<a href="' . route('admin.customers.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                }

                if(auth()->user()->can('customers_delete')) {
                    $retAction .='<form class="float-left pl-2" action="' . route('admin.customers.destroy', $user) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></form>';
                }

                return $retAction;
            })
            ->addColumn('image', function ($user) {
                return '<figure class="avatar mr-2"><img src="' . $user->images . '" alt=""></figure>';
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->addColumn('credit', function ($user) {
                return currencyFormat(optional($user->balance)->balance);
            })
            ->editColumn('id', function ($user) {
                return $user->setID;
            })
            ->escapeColumns([])
            ->make(true);
    }

    private function username($email)
    {
        $emails = explode('@', $email);
        return $emails[0] . mt_rand();
    }

}
