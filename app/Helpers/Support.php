<?php

namespace App\Helpers;

class Support
{
    public static function checking($web_purchase_code = null, $web_purchase_username = null)
    {        
        $postData = array(
            'purchase_code' => $web_purchase_code ? $web_purchase_code : env('PURCHASE_CODE'),
            'username'      => $web_purchase_username ? $web_purchase_username : env('PURCHASE_USERNAME'),
            'itemId'        => config('installer.itemId'),
            'ip'            => Ip::get(),
            'domain'        => getDomain(),
            'purpose'       => 'install',
            "sql"           => false,
            'product_name'  => config('installer.item_name'),
            'version'       => config('installer.item_version')
        );
        

        try {
            $apiUrl = config('installer.purchaseCodeCheckerUrl');
            $data = Curl::request($apiUrl, $postData);
        } catch (\Exception $e) {

            return $e->getMessage();
        }
        return $data;

    }
}
