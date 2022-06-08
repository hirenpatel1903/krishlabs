<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;


class CustomerController extends Controller
{

    function __construct()
    {
    }

    public function index(Request $request)
    {

        return view('frontend.customer.index', ['details' => true,'phone'=>null]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkBalance(Request $request)
    {

        $request->validate(
            ['phone' => 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:10']);

        $role = Role::find(2);
        $customer = User::role($role->name)->where('phone', $request->phone)->first();
        $details = false;
        $phone = $request->phone;
        return view('frontend.customer.index', compact('customer', 'details','phone'));
    }

}
