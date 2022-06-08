<?php

namespace App\Notifications;

use App\Channels\Messages\WhatsAppMessage;
use App\Channels\SendSessionMessageWhatsAppChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Channels\WhatsAppChannel;

class DepositCreated extends Notification implements ShouldQueue
{
    use Queueable;

    private $deposit;

    /**
     * Create a new notification instance.
     *
     * @param $deposit
     */
    public function __construct($deposit)
    {
        $this->deposit = $deposit;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $array = ['database',SendSessionMessageWhatsAppChannel::class,WhatsAppChannel::class];

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
        $msg = "Dear ".$this->deposit->user->name.", ".currencyFormat($this->deposit->amount) ." have been successfully added your credit.  current credit amount is ".currencyFormat($this->deposit->user->balance->balance).". Happy Shopping for Details: {$userUrl}";

        return (new WhatsAppMessage)
            ->content($msg);
    }

    public function toSendSessionMessageWhatsAppChannel($notifiable)
    {
        $userUrl = url("/");
        $msg = "Dear ".$this->deposit->user->name.", ".currencyFormat($this->deposit->amount) ." have been successfully added your credit.  current credit amount is ".currencyFormat($this->deposit->user->balance->balance).". Happy Shopping for Details: {$userUrl}";

        return (new WhatsAppMessage)
            ->content($msg);
    }
}
