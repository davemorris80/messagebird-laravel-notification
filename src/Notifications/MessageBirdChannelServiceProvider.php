<?php

namespace MessageBird\Notifications;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;

class MessageBirdChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $channels = [
            'messagebird-messenger' => Facebook::class,
            'messagebird-whatsapp' => WhatsApp::class,
            'messagebird-sms' => Sms::class,
        ];

        foreach($channels as $name => $className) {
            Notification::extend($name, function () use ($className) {
                return new $className;
            });
        }
    }
}
