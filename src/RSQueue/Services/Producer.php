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

namespace RSQueue\Services;

use RSQueue\Event\RSQueueProducerEvent;
use RSQueue\RSQueueEvents;
use RSQueue\Services\Abstracts\AbstractService;

/**
 * Provider class.
 */
class Producer extends AbstractService
{
    /**
     * Enqueues payload inside desired queue.
     *
     * @param string $queueAlias Name of queue to enqueue payload
     * @param mixed  $payload    Data to enqueue
     *
     * @return Producer self Object
     */
    public function produce($queueAlias, $payload)
    {
        $queue = $this
            ->queueAliasResolver
            ->getQueue($queueAlias);

        $payloadSerialized = $this
            ->serializer
            ->apply($payload);

        $this
            ->redis
            ->rpush(
                $queue,
                $payloadSerialized
            );

        /*
         * Dispatching producer event...
         */
        $producerEvent = new RSQueueProducerEvent(
            $payload,
            $payloadSerialized,
            $queue,
            $this->redis
        );

        $this
            ->eventDispatcher
            ->dispatch(
                RSQueueEvents::RSQUEUE_PRODUCER,
                $producerEvent
            );

        return $this;
    }
}
