<?php

namespace App\Http\Controllers;

use App\Enums\PaymentMethod;
use App\Enums\UserStatus;
use App\Http\Requests\CustomerRequest;
use App\Http\Services\DepositService;
use App\Http\Services\StripeService;
use App\Models\Deposit;
use App\Models\User;
use App\Notifications\CustomerCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Razorpay\Api\Api;
use DNS2D;

class CheckInController extends Controller
{

    function __construct()
    {
    }

    public function index()
    {
        return view('frontend.check-in.home');
    }

    /**
     * Show the step 1 Form for creating a new product.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createStepOne(Request $request)
    {
        return view('frontend.check-in.step-one');
    }

    /**
     * Post Request to store step1 info in session
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateStepOne(CustomerRequest $request)
    {

        $customer['first_name'] = strip_tags($request->first_name);
        $customer['last_name']  = strip_tags($request->last_name);
        $customer['phone']      = strip_tags($request->phone);
        $customer['username']   = strip_tags($request->first_name);
        $customer['status']     = UserStatus::ACTIVE;
        $customer['password']   = Hash::make('123456');

        $user = User::create($customer);
        $role = Role::find(2);
        $user->assignRole($role->name);

        $deposit = new Deposit;
        $deposit->user_id = $user->id;
        $deposit->amount = $request->deposit_amount;
        $deposit->save();

        $this->qrCode($user);

        $depositAmount = $deposit->amount;
        if(blank($depositAmount)) {
            $depositAmount = 0;
        }
        if ($request->payment_type == PaymentMethod::STRIPE) {
            $stripeService    = new StripeService();
            $stripeParameters = [
                'amount'      => $depositAmount,
                'currency'    => 'USD',
                'token'       => request('stripeToken'),
                'description' => 'N/A',
            ];

            $payment = $stripeService->payment($stripeParameters);
            if($payment){
                $depositService = app(DepositService::class)->depositAdjust( $user->id, $user->balance_id,$depositAmount);
            }
        } elseif ($request->payment_type == PaymentMethod::RAZORPAY){
            $payment =$this->payment($request->razorpay_payment_id,$request->deposit_amount);
            if($payment){
                $depositService = app(DepositService::class)->depositAdjust( $user->id, $user->balance_id,$depositAmount);
            }
        } else {
            $depositService = app(DepositService::class)->depositAdjust( $user->id, $user->balance_id,$depositAmount);
        }
        if(setting('twilio_disabled') || setting('wati_disabled')){
            try {
                $user->notify(new CustomerCreated($user));
            }catch (\Exception $exception){
                //
            }
        }

        return redirect(route('/'))->withSuccess('The Data Inserted Successfully');
    }

    public function qrCode($user){
        $folderPath = "images/";

        $qrCodeImage ='data:image/png;base64,' .DNS2D::getBarcodePNG('customer-'.(string)$user->id, 'QRCODE',20,20,array(1,1,1),true);

        $image_parts = explode(";base64,", $qrCodeImage);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . uniqid() . '.'.$image_type;
        file_put_contents($file, $image_base64);

        $url = public_path($file);
        $user->media()->delete();
        $user->addMediaFromUrl($url)->toMediaCollection('users');
        File::delete($url);
        return true;
    }

    public function payment($id,$amount)
    {

        $api = new Api(setting('razorpay_key'), setting('razorpay_secret'));
        $payment = $api->payment->fetch($id);

        if(!empty($id)) {
            try {
                $response = $api->payment->fetch($id)->capture(array('amount'=>$amount));

            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['msg'=>$e->getMessage()]);
            }

        }

        return true;
    }

}
