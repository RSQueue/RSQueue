<?php

/*
 * This file is part of the RSQueue library
 *
 * Copyright (c) 2016 Marc Morera
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

namespace RSQueue\Factory;

use Redis;

/**
 * Interface for any kind of serialization.
 */
class RedisFactory
{
    /**
     * @var array
     *
     * Settings for connection to redis.
     *
     * This value is set in bundle config file
     */
    public $config;

    /**
     * RedisFactory constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Generate new Predis instance.
     *
     * @return Redis
     */
    public function get()
    {
        $redis = new Redis();
        $redis->connect($this->config['host'], $this->config['port']);
        $redis->setOption(Redis::OPT_READ_TIMEOUT, -1);
        if ($this->config['database']) {
            $redis->select($this->config['database']);
        }

        return $redis;
    }
}
