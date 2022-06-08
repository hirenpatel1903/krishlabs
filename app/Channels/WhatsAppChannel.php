<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class WhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWhatsApp($notifiable);

        $to = $notifiable->routeNotificationFor('WhatsApp');
        $from = setting('twilio_from');


        $twilio = new Client(setting('twilio_account_sid'),setting('twilio_auth_token'));


        if($message->mediaUrl){
            return $twilio->messages->create('whatsapp:'.$to, [
                "mediaUrl" => [$message->mediaUrl],
                "from" => 'whatsapp:' . $from,
                "body" => $message->content
            ]);
        }else{
            return $twilio->messages->create('whatsapp:'.$to, [
                "from" => 'whatsapp:' . $from,
                "body" => $message->content
            ]);
        }

    }
}
