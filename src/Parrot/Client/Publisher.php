<?php
namespace Parrot\Client;
use Predis;

class Publisher {
    protected $redis;

    public function __construct($parameters = null, $options = null){
        $this->redis = new Predis\Client($parameters, $options);
    }

    /**
     * @param $channel
     * @param $message
     */
    public function set($channel, $message){
        $this->redis->publish($channel, $message);
    }
}