<?php

namespace Parrot\Server;

use Predis;

class Worker {

    protected $redis;
    private $pubSub;

    public function __construct($parameters = null, $options = null){
        $parameters['read_write_timeout'] = 25;
        $this->redis = new Predis\Client($parameters, $options);
        $this->pubSub = $this->redis->pubSubLoop();
    }

    public function subscribe($channel /*, ... */){
        $this->pubSub->subscribe($channel);

        try {
            foreach ($this->pubSub as $message) {
                switch ($message->kind) {
                    case 'subscribe_':
                        return [
                            'timestamp' => time(),
                            'type' => 'subscribe',
                            'data' => [
                                'chanel' => $message->channel
                            ]
                        ];
                        break;

                    case 'message':
                        return [
                            'timestamp' => time(),
                            'type' => 'message',
                            'data' => [
                                'chanel' => $message->channel,
                                'message' => $message->payload
                            ]
                        ];
                        break;
                }
            }
        } catch (\Exception $exception){
            return [
                'timestamp' => time(),
                'type' => 'reconnect',
                'data' => [
                    'chanel' => $message->channel
                ]
            ];
        }
    }

}