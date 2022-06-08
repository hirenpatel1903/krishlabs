<?php
/**
 * Created by PhpStorm.
 * User: dipok
 * Date: 5/3/20
 * Time: 11:25 AM
 */

namespace App\Http\Services;

use App\Http\Services\BasePaymentGateway;
use Omnipay\Omnipay;

class StripeService implements BasePaymentGateway
{
    public function configaration()
    {
        return setting('stripe_secret');   
    }

    public function payment( array $parameters )
    {
        $gateway = Omnipay::create('Stripe');
        $gateway->setApiKey($this->configaration());
        $response = $gateway->purchase($parameters)->send();
        return $response;
    }

    public function redirectUrl()
    {
           
    }

    public function response()
    {
        
    }
}