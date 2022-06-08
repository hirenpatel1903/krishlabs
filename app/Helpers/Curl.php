<?php


namespace App\Helpers;

use GuzzleHttp\Client;

class Curl
{
    public static function request($url, $postData)
    {
        $http = new Client();

        $parameters = [
            'headers' => [
                'User-Agent'    => $_SERVER['HTTP_USER_AGENT']
            ],
            'form_params' => $postData
        ];

        $response = $http->request('POST', $url, $parameters);

        $header      = explode(';', $response->getHeader('Content-Type')[0]);
        $contentType = $header[0];
        if ( $contentType == 'application/json' ) {
            $contents = $response->getBody()->getContents();
            $data     = json_decode($contents);
            if ( json_last_error() == JSON_ERROR_NONE ) {
                return $data;
            }
            return $contents;
        }
        return false;
    }
}
