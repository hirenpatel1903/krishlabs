<?php

namespace App\Http\Controllers;

use App\Helpers\Curl;
use App\Helpers\Ip;
use App\Http\Requests\PurchaseCodeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PurchaseCodeController extends Controller
{
    public function index()
    {
        return view('vendor.installer.purchase-code');
    }

    public function action(PurchaseCodeRequest $request)
    {
        // Check purchase code
        $purchase_code_data = $this->purchaseCodeChecker($request);

        if ($purchase_code_data->status == false) {
            return redirect()->back()->withInput($request->all())->withErrors($purchase_code_data->message);
        } else {

            
            Session::put('purchase_code', $request->get('purchase_code'));
            Session::put('purchase_username', $request->get('purchase_username'));

        }

        return redirect()->route('LaravelInstaller::environment');
    }

    /**
     * @param Request $request
     * @return false|mixed|string
     */
    private function purchaseCodeChecker(Request $request)
    {
        $postData = array(
            'purchase_code' => $request->get('purchase_code'),
            'username'      => $request->get('purchase_username'),
            'itemId'        => config('installer.itemId'),
            'ip'            => Ip::get(),
            'domain'        => getDomain(),
            'purpose'       => 'install',
            "sql"           => false,
            'product_name'  => config('installer.item_name'),
            'version'       => config('installer.item_version')
        );

        $apiUrl = config('installer.purchaseCodeCheckerUrl');

        $data = Curl::request($apiUrl, $postData);

        return $data;
    }
}
