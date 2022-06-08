<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use App\Channels\WatiWhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\WhatsAppChannel;

class CustomerCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $user;

    /**
     * Create a new notification instance.
     *
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $array = ['database',WatiWhatsAppChannel::class,WhatsAppChannel::class ];

        if (setting('twilio_disabled') != true &&
            !blank(setting('twilio_from')) &&
            !blank(setting('twilio_account_sid')) &&
            !blank(setting('twilio_account_sid'))
        ) {
            array_push($array, TwilioChannel::class);
        }

        if (setting('mail_disabled') != true &&
            !blank(setting('mail_host')) &&
            !blank(setting('mail_username')) &&
            !blank(setting('mail_password')) &&
            !blank(setting('mail_port')) &&
            !blank(setting('mail_from_name')) &&
            !blank(setting('mail_from_address'))
        ) {
            array_push($array, 'mail');
        }

        return $array;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    /**
     * @param $notifiable
     * @return \NotificationChannels\Twilio\TwilioMessage|TwilioSmsMessage
     */
    public function toTwilio($notifiable)
    {

    }
    public function toWhatsApp($notifiable)
    {
        $userUrl = url("/");
        $Date = $this->user->created_at->addDays(4)->toFormattedDateString();
        $msg = "Dear ".$this->user->name.", Congratulations ! You have been successfully registered at ".setting('site_name').".Your current credit amount is ".currencyFormat($this->user->balance->balance).". Happy Shopping for Details: {$userUrl}";

        return (new WhatsAppMessage)
            ->content($msg)
            ->mediaUrl(asset($this->user->getFirstMediaUrl('users')));
    }
    public function toWatiWhatsApp($notifiable)
    {
        $postBodyData = array(
            "user" => $this->user->name,
            "site_name" => setting('site_name'),
            "balance" => currencyFormat($this->user->balance->balance),
            "site_url" => url("/"),
        );
        return (new WhatsAppMessage)
            ->content($postBodyData)
            ->mediaUrl($this->user->getMedia('users')[0]->getPath());
    }
}
