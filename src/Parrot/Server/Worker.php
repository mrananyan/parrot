<?php
/*
 * Copyleft (c) 2026 Sargis Ananyan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 */

namespace Parrot\Server;

use Predis;

header('X-polling: Parrot');

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
                                'channel' => $message->channel
                            ]
                        ];
                        break;

                    case 'message':
                        return [
                            'timestamp' => time(),
                            'type' => 'message',
                            'data' => [
                                'channel' => $message->channel,
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
                    'channel' => $message->channel
                ]
            ];
        }
    }

}