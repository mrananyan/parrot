<?php
namespace Parrot\Client;
use Predis;

class Publisher {
    protected $redis;

    public function __construct($parameters = null, $options = null){
        $this->redis = new Predis\Client($parameters, $options);
    }

    /**
     * @param $chanel
     * @param $message
     */
    public function set($chanel, $message){
        $this->redis->publish($chanel, $message);
    }
}