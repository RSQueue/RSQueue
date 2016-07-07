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

namespace RSQueue\Event\Abstracts;

use Redis;
use Symfony\Component\EventDispatcher\Event;

/**
 * Abstract event.
 */
abstract class AbstractRSEvent extends Event
{
    /**
     * @var mixed
     *
     * Payload
     */
    protected $payload;

    /**
     * @var string
     *
     * Payload serialized
     */
    protected $payloadSerialized;

    /**
     * @var Redis
     *
     * Redis instance
     */
    protected $redis;

    /**
     * Construct method.
     *
     * @param mixed  $payload
     * @param string $payloadSerialized
     * @param Redis  $redis
     */
    public function __construct(
        $payload,
        string $payloadSerialized,
        Redis $redis
    ) {
        $this->payload = $payload;
        $this->payloadSerialized = $payloadSerialized;
        $this->redis = $redis;
    }

    /**
     * Return payload.
     *
     * @return mixed
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Return payload serialized.
     *
     * @return string
     */
    public function getPayloadSerialized() : string
    {
        return $this->payloadSerialized;
    }

    /**
     * Return redis instance.
     *
     * @return Redis
     */
    public function getRedis()
    {
        return $this->redis;
    }
}
