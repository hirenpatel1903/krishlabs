<?php

namespace App\Http\Controllers\Admin;

use Setting;
use App\Enums\Status;
use App\Helpers\Support;
use App\Models\Language;
use App\Libraries\MyString;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\BackendController;

class SettingController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['siteTitle'] = 'Settings';
        $this->middleware(['permission:setting']);
    }

    // Site Setting
    public function index()
    {
        $this->data['language'] = Language::where('status', Status::ACTIVE)->get();
        return view('admin.setting.site', $this->data);
    }

    public function siteSettingUpdate(Request $request)
    {
        if (Support::checking()->status) {

            $niceNames    = [];
            $settingArray = $this->validate($request, $this->siteValidateArray(), [], $niceNames);
            foreach ($settingArray as $key => $setting) {
                $settingArray[$key] = strip_tags($setting);
            }


            if ($request->hasFile('site_logo')) {
                $site_logo                 = request('site_logo');
                $settingArray['site_logo'] = $site_logo->getClientOriginalName();
                $request->site_logo->move(public_path('images'), $settingArray['site_logo']);
            } else {
                unset($settingArray['site_logo']);
            }

            if (isset($settingArray['timezone'])) {
                MyString::setEnv('APP_TIMEZONE', $settingArray['timezone']);
                Artisan::call('optimize:clear');
            }

            Setting::set($settingArray);
            Setting::save();

            return redirect(route('admin.setting.index'))->withSuccess('The Site setting updated successfully');
        } else {
            return redirect(route('admin.setting.purchasekey'))->withError('Invalid Envato Username and Purchase code.');
        }
    }


    // EMail Setting
    public function emailSetting()
    {
        return view('admin.setting.email', $this->data);
    }

    public function emailSettingUpdate(Request $request)
    {
        $niceNames         = [];
        $emailSettingArray = $this->validate($request, $this->emailValidateArray(), [], $niceNames);
        foreach ($emailSettingArray as $key => $setting) {
            $emailSettingArray[$key] = strip_tags($setting);
        }
        Setting::set($emailSettingArray);
        Setting::save();

        return redirect(route('admin.setting.email'))->withSuccess('The Email setting updated successfully');
    }


    // SMS Setting
    public function smsSetting()
    {
        return view('admin.setting.sms', $this->data);
    }

    public function smsSettingUpdate(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->smsValidateArray(), [], $niceNames);
        foreach ($settingArray as $key => $setting) {
            $settingArray[$key] = strip_tags($setting);
        }
        Setting::set($settingArray);
        Setting::save();
        return redirect(route('admin.setting.sms'))->withSuccess('The SMS setting updated successfully.');
    }

    // Payment Setting
    public function paymentSetting()
    {
        return view('admin.setting.payment', $this->data);
    }

    public function paymentSettingUpdate(Request $request)
    {
        if ($request->settingtypepayment == 'stripe') {
            $this->stripeSetting($request);
        } else if ($request->settingtypepayment == 'razorpay') {
            $this->razorpaySetting($request);
        } else if ($request->settingtypepayment == 'paystack') {
            $this->paystackSetting($request);
        } else {
            return redirect(route('admin.setting.payment'));
        }
        return redirect(route('admin.setting.payment'))->withSuccess('The Payment setting updated successfully.');
    }

    private function stripeSetting($request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->stripeValidateArray(), [], $niceNames);
        foreach ($settingArray as $key => $setting) {
            $settingArray[$key] = strip_tags($setting);
        }
        Setting::set($settingArray);
        Setting::save();
    }

    private function razorpaySetting($request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->razorpayValidateArray(), [], $niceNames);
        foreach ($settingArray as $key => $setting) {
            $settingArray[$key] = strip_tags($setting);
        }
        Setting::set($settingArray);
        Setting::save();
    }

    private function paystackSetting($request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->paystackValidateArray(), [], $niceNames);
        foreach ($settingArray as $key => $setting) {
            $settingArray[$key] = strip_tags($setting);
        }
        Setting::set($settingArray);
        Setting::save();
    }

    // WhatsApp SMS Setting
    public function whatsAppSetting()
    {
        return view('admin.setting.whatsapp', $this->data);
    }

    public function whatsAppSettingUpdate(Request $request)
    {
        $niceNames    = [];
        $settingArray = $this->validate($request, $this->whatsappValidateArray(), [], $niceNames);
        foreach ($settingArray as $key => $setting) {
            $settingArray[$key] = strip_tags($setting);
        }
        Setting::set($settingArray);
        Setting::save();
        return redirect(route('admin.setting.whatsapp'))->withSuccess('The WhatsApp SMS setting updated successfully.');
    }

    public function purchaseKeySetting()
    {
        return view('admin.setting.purchasekey', $this->data);
    }

    public function purchaseKeySettingUpdate(Request $request)
    {
        if (Support::checking($request->web_purchase_code,$request->web_purchase_username)->status) {

            $niceNames         = [];
            $purchasekeySettingArray = $this->validate($request, $this->purchaseKeyValidateArray(), [], $niceNames);

            MyString::setEnv('PURCHASE_USERNAME', $purchasekeySettingArray['web_purchase_username']);
            MyString::setEnv('PURCHASE_CODE', $purchasekeySettingArray['web_purchase_code']);
            Setting::set($purchasekeySettingArray);
            Setting::save();
            return redirect(route('admin.setting.purchasekey'))->withSuccess('The Purchase key setting updated successfully');
        } else {
            return redirect(route('admin.setting.purchasekey'))->withError('Invalid Envato Username and Purchase code.');
        }
    }

    // Site Setting validation
    private function siteValidateArray()
    {
        return [
            'site_name'                       => 'required|string|max:100',
            'site_email'                      => 'required|string|max:100',
            'site_phone_number'               => 'required', 'max:60',
            'currency_name'                   => 'required|string|max:20',
            'currency_code'                   => 'required|string|max:20',
            'site_footer'                     => 'required|string|max:200',
            'timezone'                        => 'required|string',
            'site_logo'                       => 'nullable|mimes:jpeg,jpg,png,gif|max:3096',
            'site_description'                => 'required|string|max:500',
            'site_address'                    => 'required|string|max:500',
            'locale'                          => 'nullable|string',
        ];
    }

    // EMAIL Setting validation
    private function emailValidateArray()
    {
        return [
            'mail_host'         => 'required|string|max:100',
            'mail_port'         => 'required|string|max:100',
            'mail_username'     => 'required|string|max:100',
            'mail_password'     => 'required|string|max:100',
            'mail_from_name'    => 'required|string|max:100',
            'mail_from_address' => 'required|string|max:200',
            'mail_disabled'     => 'numeric',
        ];
    }

    // SMS Setting validation
    private function smsValidateArray()
    {
        return [
            'twilio_auth_token'  => 'required|string|max:200',
            'twilio_account_sid' => 'required|string|max:200',
            'twilio_from'        => 'required|string|max:20',
            'twilio_disabled'    => 'numeric',
        ];
    }

    // Payment Setting validation
    public function stripeValidateArray()
    {
        return [
            'stripe_key'         => 'required|string|max:255',
            'stripe_secret'      => 'required|string|max:255',
            'settingtypepayment' => 'required|string',
            'stripe_disabled' => 'required|numeric',
        ];
    }

    public function razorpayValidateArray()
    {
        return [
            'razorpay_key'       => 'required|string|max:255',
            'razorpay_secret'    => 'required|string|max:255',
            'settingtypepayment' => 'required|string',
            'razorpay_disabled' => 'required|numeric',
        ];
    }

    private function paystackValidateArray()
    {
        return [
            'paystack_key'       => 'required|string|max:255',
            'settingtypepayment' => 'required|string',
        ];
    }


    // SMS Setting validation
    private function whatsappValidateArray()
    {
        return [
            'wati_auth_token'  => 'required|string',
            'wati_api_endpoint' => 'required|string',
            'wati_template_name' => 'required|string',
            'wati_disabled' => 'numeric',
        ];
    }

    // PurchaseKey Setting validation
    private function purchaseKeyValidateArray()
    {
        return [
            'web_purchase_username'      => 'required|string|max:255',
            'web_purchase_code'          => 'required|string|max:255'
        ];
    }
}
