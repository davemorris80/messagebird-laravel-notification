<?php

namespace MessageBird\Notifications\Message;

abstract class Base {
    protected $from;

    public function from($from) {
        $this->from = $from;
        
        return $this;
    }

    public function getFrom($channelName){
        $defaultEnv = env('MESSAGEBIRD_FROM');
        $specificEnv = env('MESSAGEBIRD_FROM'. strtoupper($channelName));

        if (!$this->from) {
            if ($specificEnv) {
                return $specificEnv;
            }
            return $defaultEnv;
        }

        return $this->from;
    }
}
