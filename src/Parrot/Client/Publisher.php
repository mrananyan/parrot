<?php
/*
 * Copyleft (c) 2026 Sargis Ananyan
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 */

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