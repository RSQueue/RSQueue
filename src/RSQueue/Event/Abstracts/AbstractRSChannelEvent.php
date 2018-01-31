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

/**
 * Abstract channel event.
 */
abstract class AbstractRSChannelEvent extends AbstractRSEvent
{
    /**
     * @var string
     *
     * Real channel name
     */
    private $channelName;

    /**
     * Construct method.
     *
     * @param mixed              $payload
     * @param string             $payloadSerialized
     * @param string             $channelName
     * @param Redis|RedisCluster $redis
     */
    public function __construct(
        $payload,
        string $payloadSerialized,
        string $channelName,
        Redis $redis
    ) {
        parent::__construct(
            $payload,
            $payloadSerialized,
            $redis
        );

        $this->channelName = $channelName;
    }

    /**
     * Return channel name.
     *
     * @return string Channel name
     */
    public function getChannelName() : string
    {
        return $this->channelName;
    }
}
