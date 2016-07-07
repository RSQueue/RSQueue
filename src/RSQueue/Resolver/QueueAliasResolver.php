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

namespace RSQueue\Resolver;

use RSQueue\Exception\InvalidAliasException;

/**
 * Abstract service.
 *
 * Provides base structure of all rsqueue services
 */
class QueueAliasResolver
{
    /**
     * @var array
     *
     * Queue names. Key is alias, value is queue real name
     *
     * This value is set in bundle config file
     */
    private $queues;

    /**
     * @var array
     *
     * Queue aliases. Key is queue real name, value is alias
     */
    private $queueAliases;

    /**
     * Construct method.
     *
     * @param array $queues Queue names array
     */
    public function __construct(array $queues)
    {
        $this->queues = $queues;
        $this->queueAliases = array_flip($queues);
    }

    /**
     * Given an array of queueAliases, return a valid queueNames array.
     *
     * @param array $queueAlias Queue alias array
     *
     * @return array valid queueName array
     *
     * @throws InvalidAliasException If any queueAlias is not defined
     */
    public function getQueues(array $queueAlias) : array
    {
        $queues = [];
        foreach ($queueAlias as $alias) {
            $queues[] = $this->getQueue($alias);
        }

        return $queues;
    }

    /**
     * Return real queue name by defined QueueAlias.
     *
     * @param string $queueAlias Queue alias
     *
     * @return string real queue name
     *
     * @throws InvalidAliasException If queueAlias is not defined
     */
    public function getQueue($queueAlias) : string
    {
        $this->checkQueue($queueAlias);

        return $this->queues[$queueAlias];
    }

    /**
     * Check if given queue alias can be resolved.
     *
     * @param string $queueAlias Queue alias
     *
     * @return bool queue alias can be resolved
     *
     * @throws InvalidAliasException If queueAlias is not defined
     */
    public function checkQueue($queueAlias) : bool
    {
        if (!isset($this->queues[$queueAlias])) {
            throw new InvalidAliasException();
        }

        return true;
    }

    /**
     * Get alias given queue name.
     *
     * @param string $queue Queue name
     *
     * @return string Queue alias if exists
     */
    public function getQueueAlias($queue) : string
    {
        return $this->queueAliases[$queue];
    }
}
