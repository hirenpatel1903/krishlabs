<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Setting as SeederSetting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settingArray['site_name']                       = 'QuickStore';
        $settingArray['site_email']                      = 'info@pos.xyz';
        $settingArray['site_phone_number']               = '+880177700664206';
        $settingArray['site_logo']                       = 'logo.png';
        $settingArray['site_footer']                     = '@ All Rights Reserved';
        $settingArray['site_description']                = 'QuickStore management system.';
        $settingArray['site_address']                    = 'Section 1, Ground Floor, Mirpur, Dhaka 1216';
        $settingArray['currency_name']                   = 'USD';
        $settingArray['currency_code']                   = '$';

        $settingArray['timezone']                        = '';

        $settingArray['mail_host']                       = '';
        $settingArray['mail_port']                       = '';
        $settingArray['mail_username']                   = '';
        $settingArray['mail_password']                   = '';

        $settingArray['mail_from_name']                  = '';
        $settingArray['mail_from_address']               = '';
        $settingArray['mail_disabled']                   = 1;

        $settingArray['stripe_key']                      = '';
        $settingArray['stripe_secret']                   = '';
        $settingArray['razorpay_key']                    = '';
        $settingArray['razorpay_secret']                 = '';
        $settingArray['paystack_key']                    = '';

        $settingArray['purchase_code']                   = session()->has('purchase_code') ? session()->get('purchase_code') : "";
        $settingArray['purchase_username']               = session()->has('purchase_username') ? session()->get('purchase_username') : "";


        SeederSetting::set($settingArray);
        SeederSetting::save();
    }
}
