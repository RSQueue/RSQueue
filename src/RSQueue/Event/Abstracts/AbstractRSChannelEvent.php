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
     * Channel alias
     */
    protected $channelAlias;

    /**
     * @var string
     *
     * Real channel name
     */
    protected $channelName;

    /**
     * Construct method.
     *
     * @param mixed  $payload
     * @param string $payloadSerialized
     * @param string $channelAlias
     * @param string $channelName
     * @param Redis  $redis
     */
    public function __construct(
        $payload,
        string $payloadSerialized,
        string $channelAlias,
        string $channelName,
        Redis $redis
    ) {
        parent::__construct(
            $payload,
            $payloadSerialized,
            $redis
        );

        $this->channelAlias = $channelAlias;
        $this->channelName = $channelName;
    }

    /**
     * Return channel alias.
     *
     * @return string Channel alias
     */
    public function getChannelAlias()
    {
        return $this->channelAlias;
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
