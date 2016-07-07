<?php

/*
 * This file is part of the RSQueue library
 *
 * Copyright (c) 2016 Bet4talent
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
 * Abstract queue event.
 */
abstract class AbstractRSQueueEvent extends AbstractRSEvent
{
    /**
     * @var string
     *
     * Queue alias
     */
    protected $queueAlias;

    /**
     * @var string
     *
     * Real queue name
     */
    protected $queueName;

    /**
     * Construct method.
     *
     * @param mixed  $payload           Payload
     * @param string $payloadSerialized Payload serialized
     * @param string $queueAlias        Queue alias
     * @param string $queueName         Queue name
     * @param Redis  $redis             Redis instance
     */
    public function __construct(
        $payload,
        string $payloadSerialized,
        string $queueAlias,
        string $queueName,
        Redis $redis
    ) {
        parent::__construct(
            $payload,
            $payloadSerialized,
            $redis
        );

        $this->queueAlias = $queueAlias;
        $this->queueName = $queueName;
    }

    /**
     * Return queue alias.
     *
     * @return string Queue alias
     */
    public function getQueueAlias()
    {
        return $this->queueAlias;
    }

    /**
     * Return queue name.
     *
     * @return string Queue name
     */
    public function getQueueName() : string
    {
        return $this->queueName;
    }
}
