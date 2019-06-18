<?php

namespace MessageBird\Notifications;

class Sms extends MessageChannel {

    protected $channelName = 'messagebird-sms';
    protected $channelIdField = 'number';
    protected $notificationMappingMethod = 'toMessageBirdSms';
    
}

