<?php

namespace MessageBird\Notifications;

class Facebook extends MessageChannel {
    protected $channelName = 'messagebird-messenger';
    protected $channelIdField = 'id';
    protected $notificationMappingMethod = 'toMessageBirdFacebook';
}

