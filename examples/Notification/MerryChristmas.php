<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use MessageBird\Notifications\Sms;
use MessageBird\Notifications\WhatsApp;
use MessageBird\Notifications\Facebook;

use MessageBird\Notifications\Message\Text;

class MerryChristmas extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [
            Sms::class,
            WhatsApp::class,
            Facebook::class
        ];
    }

    public function toMessageBirdWhatsApp($notifiable)
    {
        return (new Text)->content('Merry Christmas WhatsApp!');
    }

    public function toMessageBirdFacebook($notifiable)
    {
        return (new Text)->content('Merry Christmas Facebook!');
    }

    public function toMessageBirdSms($notifiable)
    {
        return (new Text)->content('Merry Christmas SMS!');
    }
}

