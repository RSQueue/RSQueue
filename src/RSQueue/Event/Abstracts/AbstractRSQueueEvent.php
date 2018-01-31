<?php

/*
 * This file is part of the RSQueue library
 *
 * Copyright (c) 2016 - now() Marc Morera
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

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
     * Real queue name
     */
    private $queueName;

    /**
     * Construct method.
     *
     * @param mixed              $payload           Payload
     * @param string             $payloadSerialized Payload serialized
     * @param string             $queueName         Queue name
     * @param Redis|RedisCluster $redis             Redis instance
     */
    public function __construct(
        $payload,
        string $payloadSerialized,
        string $queueName,
        $redis
    ) {
        parent::__construct(
            $payload,
            $payloadSerialized,
            $redis
        );

        $this->queueName = $queueName;
    }

    /**
     * Return queue name.
     *
     * @return string Queue name
     */
    public function getQueueName(): string
    {
        return $this->queueName;
    }
}
