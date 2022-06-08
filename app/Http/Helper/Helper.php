<?php

if(! function_exists('pluck')) {
    function pluck( $array, $value, $key = null )
    {
        $returnArray = [];
        if ( count($array) ) {
            foreach ( $array as $item ) {
                if ( $key != null ) {
                    $returnArray[ $item->$key ] = strtolower($value) == 'obj' ? $item : $item->$value;
                } else {
                    if ( $value == 'obj' ) {
                        $returnArray[] = $item;
                    } else {
                        $returnArray[] = $item->$value;
                    }
                }
            }
        }

        return $returnArray;
    }
}

if(! function_exists('currencyFormat')) {
    function currencyFormat($currency)
    {
        return Setting::get('currency_code').number_format($currency, 2);
    }
}

if(! function_exists('currencyFormatWithName')) {
    function currencyFormatWithName($currency)
    {
        return number_format($currency, 2) . ' '. Setting::get('currency_name');
    }
}

if(! function_exists('transactionCurrencyFormat')) {
    function transactionCurrencyFormat($transaction)
    {
        $amount = '+ '.$transaction->amount;
        if($transaction->source_balance_id == auth()->user()->balance_id) {
            $amount = '- '.$transaction->amount;
        }
        return $amount;
    }
}

if(! function_exists('settingLogo')) {
    function settingLogo()
    {
        return asset("images/".setting('site_logo'));
    }
}

if(! function_exists('food_date_format')) {
    function food_date_format($date) {
        return \Carbon\Carbon::parse($date)->format('d M Y h:i A');
    }
}

if(! function_exists('food_date_format_with_day')) {
    function food_date_format_with_day($date) {
        return \Carbon\Carbon::parse($date)->format('l, d M Y h:i A');
    }
}



/**
 * Get domain (host without sub-domain)
 *
 * @param null $url
 * @return string
 */
function getDomain($url = null)
{
    if (!empty($url)) {
        $host = parse_url($url, PHP_URL_HOST);
    } else {
        $host = getHost();
    }

    $tmp = explode('.', $host);
    if (count($tmp) > 2) {
        $itemsToKeep = count($tmp) - 2;
        $tlds = config('tlds');
        if (isset($tmp[$itemsToKeep]) && isset($tlds[$tmp[$itemsToKeep]])) {
            $itemsToKeep = $itemsToKeep - 1;
        }
        for ($i = 0; $i < $itemsToKeep; $i++) {
            \Illuminate\Support\Arr::forget($tmp, $i);
        }
        $domain = implode('.', $tmp);
    } else {
        $domain = @implode('.', $tmp);
    }

    return $domain;
}

/**
 * Get host (domain with sub-domain)
 *
 * @param null $url
 * @return array|mixed|string
 */
function getHost($url = null)
{
    if (!empty($url)) {
        $host = parse_url($url, PHP_URL_HOST);
    } else {
        $host = (trim(request()->server('HTTP_HOST')) != '') ? request()->server('HTTP_HOST') : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
    }

    if ($host == '') {
        $host = parse_url(url()->current(), PHP_URL_HOST);
    }

    return $host;
}

function isValidJson($string)
{
    try {
        json_decode($string);
    } catch (\Exception $e) {
        return false;
    }

    return (json_last_error() == JSON_ERROR_NONE);
}
