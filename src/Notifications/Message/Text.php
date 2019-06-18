<?php

namespace MessageBird\Notifications\Message;

class Text extends Base {

    protected $content;

    public function content($content) {
        $this->content = $content;
        
        return $this;
    }

    public function toMessageBirdApi($from, $to) {
        return [
            'from' => $from,
            'to' => $to,
            'message' => [
                'content' => [
                    'type' => 'text',
                    'text' => $this->content
                ]
            ]
        ];
    }
}
