<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;


class SendSessionMessageWhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSendSessionMessageWhatsAppChannel($notifiable);

        $to = $notifiable->routeNotificationFor('WhatsApp');
        $token = setting('wati_auth_token');
        $apiUrl = setting('wati_api_endpoint').'/api/v1/sendSessionMessage/'.$to;

        $postData = array(
            "messageText" => $message->content,
        );

        $http = new Client();
        $parameters = [
            'headers' => [
                'User-Agent' => $_SERVER['HTTP_USER_AGENT'],
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
                'Authorization' => $token,
            ],
            'query' => $postData
        ];

        $response = $http->request('POST', $apiUrl, $parameters);
        $header = explode(';', $response->getHeader('Content-Type')[0]);
        $contentType = $header[0];
        if ($contentType == 'application/json') {
            $contents = $response->getBody()->getContents();
            $data = json_decode($contents);
        }
    }
}
