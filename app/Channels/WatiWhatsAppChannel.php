<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;


class WatiWhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWatiWhatsApp($notifiable);
        $to = $notifiable->routeNotificationFor('WhatsApp');
        $templateName = setting('wati_template_name');
        $token = setting('wati_auth_token');
        $url = setting('wati_api_endpoint');
       $this->textSend($templateName,$to,$token,$url,$message);
       $this->fileSend($to,$token,$url,$message,$notifiable);
    }

    private function textSend($templateName,$to,$token,$url,$message){
        $http = new Client();
        $apiUrlText =  $url.'/api/v1/sendTemplateMessage';
        $postBodyData = array(
            "template_name" => $templateName,
            "broadcast_name" => "Customers Add",
            "parameters" => [
                array("name" => "name", "value" => $message->content['user']),
                array("name" => "sitename", "value" => $message->content['site_name']),
                array("name" => "balance", "value" => $message->content['balance']),
                array("name" => "siteurl", "value" => $message->content['site_url'])
            ]
        );
        $request_data = json_encode($postBodyData);
        $parameters = [
            'headers' => [
                'User-Agent' => $_SERVER['HTTP_USER_AGENT'],
                'Accept' => '*/*',
                'Content-Type' => 'application/json',
                'Authorization' => $token,
            ],
            'query' => [
                'whatsappNumber' => $to,
            ],
            'body' => $request_data,
        ];

        $response = $http->request('POST', $apiUrlText, $parameters);
        $header = explode(';', $response->getHeader('Content-Type')[0]);
        $contentType = $header[0];
        if ($contentType == 'application/json') {
            $contents = $response->getBody()->getContents();
            $data = json_decode($contents);
        }
    }

    private function fileSend($to,$token,$url,$message,$notifiable){

        $fileName = $notifiable->getMedia('users')[0]->file_name;

        $apiUrl =  $url.'/api/v1/sendSessionFile/'.$to;

        $client = new Client(['headers' => ['Authorization' => $token]]);
        $options = [
            'multipart' => [
                [
                    'Content-type' => 'multipart/form-data',
                    'name' => 'file',
                    'contents' => fopen($message->mediaUrl, 'r'),
                    'filename' => $fileName,
                ],
            ],
        ];

        $response = $client->post($apiUrl, $options);
        $header = explode(';', $response->getHeader('Content-Type')[0]);
        $contentType = $header[0];
        if ($contentType == 'application/json') {
            $contents = $response->getBody()->getContents();
            $data = json_decode($contents);
        }
    }

}
