<?php

namespace MessageBird\Notifications;

use Illuminate\Notifications\Notification;

abstract class MessageChannel {

    protected $channelName;
    protected $channelIdField;
    protected $channelFromField;
    protected $notificationMappingMethod;

    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor($this->channelName)) {
            return;
        }

        $this->messageBirdChannelName = str_replace('messagebird-', '', $this->channelName);

        $message = $notification->{$this->notificationMappingMethod}($notifiable);

        $response = $this->sendMessage(
            $message->toMessageBirdApi(
                $this->from($message->getFrom($this->messageBirdChannelName)),
                $this->to($to)
            )
        );
    }

    protected function toEndpoint($id, $field) {
        return ['type' => $this->messageBirdChannelName, $field => $id];
    }

    protected function to($id) {
        return $this->toEndpoint($id, $this->channelIdField);
    }

    protected function from($id) {
        $field = $this->channelIdField;

        if ($this->channelFromField) {
            $field = $this->channelFromField;
        }

        return $this->toEndpoint($id, $field);
    }

    protected function sendMessage($body) {

        $client = new \GuzzleHttp\Client();

        return $client->request('POST', 'https://conversations.messagebird.com/v1', [
            'headers' => [
                'Authorization' => 'AccessKey '. config('messagebird.api.key'),
                'Content-Type' => 'application/json', 
                'Accept' => 'application/json'
            ],
            'body' => json_encode($body)
        ]);
    }
}

