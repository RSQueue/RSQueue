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

use RSQueue\Event\RSQueueConsumerEvent;
use RSQueue\RSQueueEvents;
use RSQueue\Services\Abstracts\AbstractService;

/**
 * Consumer class.
 *
 * This class
 */
class Consumer extends AbstractService
{
    /**
     * Retrieve queue value, with a defined timeout.
     *
     * This method accepts a single queue alias or an array with alias
     * Every new element will be popped from one of defined queue
     *
     * Also, new Consumer event is triggered everytime a new element is popped
     *
     * @param mixed $queueAlias Alias of queue to consume from ( Can be an array of alias )
     * @param int   $timeout    Timeout. By default, 0
     *
     * @return mixed payload unserialized
     */
    public function consume($queueAlias, $timeout = 0)
    {
        $queues = is_array($queueAlias)
            ? $this
                ->queueAliasResolver
                ->getQueues($queueAlias)
            : $this
                ->queueAliasResolver
                ->getQueue($queueAlias);

        $payloadArray = $this
            ->redisAdapter
            ->blPop(
                $queues,
                $timeout
            );

        if (empty($payloadArray)) {
            return [];
        }

        list($givenQueue, $payloadSerialized) = $payloadArray;
        $payload = $this->serializer->revert($payloadSerialized);
        $givenQueueAlias = $this
            ->queueAliasResolver
            ->getQueue($givenQueue);

        /*
         * Dispatching consumer event...
         */
        $consumerEvent = new RSQueueConsumerEvent(
            $payload,
            $payloadSerialized,
            $givenQueue,
            $this->redisAdapter->getClient()
        );

        $this
            ->eventDispatcher
            ->dispatch(RSQueueEvents::RSQUEUE_CONSUMER, $consumerEvent);

        return [$givenQueueAlias, $payload];
    }
}
