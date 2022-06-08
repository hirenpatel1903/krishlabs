<?php

namespace App\Http\Services;

interface BasePaymentGateway 
{
	public function configaration();
	public function payment(array $parameters);
	public function redirectUrl();

} 