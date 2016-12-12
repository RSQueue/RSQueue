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

use RSQueue\Exception\UnknownDriverException;
use RSQueue\Redis\AdapterInterface;
use RSQueue\Redis\PredisClientAdapter;
use RSQueue\Redis\RedisAdapter;

/**
 * Return an AdapterInterface switch Redis driver
 * Class RedisFactory
 * @package RSQueue\Factory
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
     * Generate a AdapterInterface instance
     * @return AdapterInterface
     * @throws UnknownDriverException
     */
    public function get() : AdapterInterface
    {
        if ($this->config['driver'] === 'predis') {
            $redis = $this->getPredisClient($this->config);
            return new PredisClientAdapter($redis);
        } elseif($this->config['driver'] === 'phpredis') {
            $redis = $this->getPHPRedisClient($this->config);
            return new RedisAdapter($redis);
        }else{
            throw new UnknownDriverException(sprintf("Unknown driver '%s'",$this->config['driver']));
        }
    }

    /**
     * @param array $config
     * @return \Redis
     */
    protected function getPHPRedisClient(array $config) : \Redis
    {
        $redis = new \Redis;
        $redis->connect($config['host'], $config['port']);
        $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
        if ($config['database']) {
            $redis->select($config['database']);
        }
        return $redis;
    }

    /**
     * @param array $config
     * @return \Predis\Client
     */
    protected function getPredisClient(array $config) : \Predis\Client
    {
        $connectionParameters = array(
            'scheme' => 'tcp',
            'host' => $config['host'],
            'port' => $config['port'],
            'read_write_timeout' => -1
        );
        if ($config['database']) {
            $connectionParameters['database'] = $config['database'];
        }
       return new \Predis\Client($connectionParameters);
    }
}
