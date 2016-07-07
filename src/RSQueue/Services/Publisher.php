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

namespace RSQueue\Services;

use RSQueue\Event\RSQueuePublisherEvent;
use RSQueue\Exception\InvalidAliasException;
use RSQueue\RSQueueEvents;
use RSQueue\Services\Abstracts\AbstractService;

/**
 * Publisher class.
 */
class Publisher extends AbstractService
{
    /**
     * Enqueues payload inside desired queue.
     *
     * @param string $channelAlias Name of channel to publish payload
     * @param mixed  $payload      Data to publish
     *
     * @return Producer self Object
     *
     * @throws InvalidAliasException If any alias is not defined
     */
    public function publish($channelAlias, $payload)
    {
        $channel = $this
            ->queueAliasResolver
            ->getQueue($channelAlias);

        $payloadSerialized = $this
            ->serializer
            ->apply($payload);

        $this
            ->redis
            ->publish(
                $channel,
                $payloadSerialized
            );

        /*
         * Dispatching publisher event...
         */
        $publisherEvent = new RSQueuePublisherEvent(
            $payload,
            $payloadSerialized,
            $channelAlias,
            $channel,
            $this->redis
        );

        $this
            ->eventDispatcher
            ->dispatch(
                RSQueueEvents::RSQUEUE_PUBLISHER,
                $publisherEvent
            );

        return $this;
    }
}
