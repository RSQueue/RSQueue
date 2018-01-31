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

namespace RSQueue\Services\Abstracts;

use Redis;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use RSQueue\Resolver\QueueAliasResolver;
use RSQueue\Serializer\Serializer;

/**
 * Abstract service.
 *
 * Provides base structure of all rsqueue services
 */
class AbstractService
{
    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcher instance
     */
    protected $eventDispatcher;

    /**
     * @var Redis
     *
     * Redis client used to interact with redis service
     */
    protected $redis;

    /**
     * @var QueueAliasResolver
     *
     * Queue alias resolver
     */
    protected $queueAliasResolver;

    /**
     * @var Serializer
     *
     * Serializer
     */
    protected $serializer;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param Redis|RedisCluster       $redis
     * @param QueueAliasResolver       $queueAliasResolver
     * @param Serializer               $serializer
     *
     * Construct method
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        $redis,
        QueueAliasResolver $queueAliasResolver,
        Serializer $serializer
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->redis = $redis;
        $this->queueAliasResolver = $queueAliasResolver;
        $this->serializer = $serializer;
    }
}
