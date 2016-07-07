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

namespace RSQueue;

/**
 * Events dispatched by RSQueueBundle.
 */
final class RSQueueEvents
{
    /**
     * The rsqueue.consumer is thrown each time a job is consumed by consumer.
     *
     * The event listener recieves an
     * RSQueueBundle\Event\RSQueueConsumerEvent instance
     *
     * @var string
     */
    const RSQUEUE_CONSUMER = 'rsqueue.consumer';

    /**
     * The rsqueue.subscriber is thrown each time a job is consumed by subscriber.
     *
     * The event listener recieves an
     * RSQueueBundle\Event\RSQueueSubscriberEvent instance
     *
     * @var string
     */
    const RSQUEUE_SUBSCRIBER = 'rsqueue.subscriber';

    /**
     * The rsqueue.producer is thrown each time a job is consumed by producer.
     *
     * The event listener recieves an
     * RSQueueBundle\Event\RSQueueProducerEvent instance
     *
     * @var string
     */
    const RSQUEUE_PRODUCER = 'rsqueue.producer';

    /**
     * The rsqueue.publisher is thrown each time a job is consumed by publisher.
     *
     * The event listener recieves an
     * RSQueueBundle\Event\RSQueuePublisherEvent instance
     *
     * @var string
     */
    const RSQUEUE_PUBLISHER = 'rsqueue.publisher';
}
