<?php

namespace MessageBird\Notifications;

class WhatsApp extends MessageChannel {

    protected $channelName = 'messagebird-whatsapp';
    protected $channelIdField = 'number';
    protected $notificationMappingMethod = 'toMessageBirdWhatsApp';
    
}
