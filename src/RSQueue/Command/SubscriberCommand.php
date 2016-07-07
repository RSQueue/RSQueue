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

namespace RSQueue\Command;

use Redis;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use RSQueue\Command\Abstracts\AbstractRSQueueCommand;
use RSQueue\Event\RSQueueSubscriberEvent;
use RSQueue\Exception\InvalidAliasException;
use RSQueue\Exception\MethodNotFoundException;
use RSQueue\Resolver\QueueAliasResolver;
use RSQueue\RSQueueEvents;
use RSQueue\Serializer\Serializer;

/**
 * Abstract Subscriber command.
 *
 * Events :
 *
 *     Each time a subscriber recieves a new element, this throws a new
 *     rsqueue.subscriber Event
 *
 * Exceptions :
 *
 *     If any of inserted queues or channels is not defined in config file
 *     as an alias, a new InvalidAliasException will be thrown
 *
 *     Likewise, if any ot inserted associated methods does not exist or is not
 *     callable, a new MethodNotFoundException will be thrown
 */
abstract class SubscriberCommand extends AbstractRSQueueCommand
{
    /**
     * @var Serializer
     *
     * Serializer
     */
    private $serializer;

    /**
     * @var QueueAliasResolver
     *
     * Queue alias resolver
     */
    private $queueAliasResolver;

    /**
     * @var EventDispatcherInterface
     *
     * Event Dispatcher
     */
    private $eventDispatcher;

    /**
     * @var Redis
     *
     * Redis
     */
    private $redis;

    /**
     * SubscriberCommand constructor.
     *
     * @param Serializer               $serializer
     * @param QueueAliasResolver       $queueAliasResolver
     * @param EventDispatcherInterface $eventDispatcher
     * @param Redis                    $redis
     */
    public function __construct(
        Serializer $serializer,
        QueueAliasResolver $queueAliasResolver,
        EventDispatcherInterface $eventDispatcher,
        Redis $redis
    ) {
        $this->serializer = $serializer;
        $this->queueAliasResolver = $queueAliasResolver;
        $this->eventDispatcher = $eventDispatcher;
        $this->redis = $redis;
    }

    /**
     * Adds a queue to subscribe on.
     *
     * Checks if queue assigned method exists and is callable
     *
     * @param string $channelAlias  Queue alias
     * @param string $channelMethod Queue method
     *
     * @return SubscriberCommand self Object
     *
     * @throws MethodNotFoundException If any method is not callable
     */
    protected function addChannel($channelAlias, $channelMethod)
    {
        return $this->addMethod($channelAlias, $channelMethod);
    }

    /**
     * Execute code.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws InvalidAliasException If any alias is not defined
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) : int {
        /*
         * Define all channels this command must listen to
         */
        $this->define();

        $channelAliases = array_keys($this->methods);
        $channels = $this
            ->queueAliasResolver
            ->getQueues($channelAliases);

        if ($this->shuffleQueues()) {
            shuffle($channels);
        }

        $this
            ->redis
            ->subscribe($channels,
                function ($redis, $channel, $payloadSerialized) use ($input, $output) {

                $channelAlias = $this
                    ->queueAliasResolver
                    ->getQueueAlias($channel);

                $method = $this->methods[$channelAlias];
                $payload = $this
                    ->serializer
                    ->revert($payloadSerialized);

                /*
                 * Dispatching subscriber event...
                 */
                $subscriberEvent = new RSQueueSubscriberEvent(
                    $payload,
                    $payloadSerialized,
                    $channelAlias,
                    $channel,
                    $redis
                );

                $this
                    ->eventDispatcher
                    ->dispatch(
                        RSQueueEvents::RSQUEUE_SUBSCRIBER,
                        $subscriberEvent
                    );

                /*
                 * All custom methods must have these parameters
                 *
                 * InputInterface  $input   An InputInterface instance
                 * OutputInterface $output  An OutputInterface instance
                 * Mixed           $payload Payload
                 */
                $this->$method(
                    $input,
                    $output,
                    $payload
                );
            });

        return 0;
    }
}
