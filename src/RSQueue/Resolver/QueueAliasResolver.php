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

namespace RSQueue\Resolver;

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
     * Construct method.
     *
     * @param array $queues Queue names array
     */
    public function __construct(array $queues)
    {
        $this->queues = $queues;
    }

    /**
     * Given an array of queueAliases, return a valid queueNames array.
     *
     * @param array $queueAlias Queue alias array
     *
     * @return array valid queueName array
     */
    public function getQueues(array $queueAlias): array
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
     */
    public function getQueue($queueAlias): string
    {
        return $this->queues[$queueAlias] ?? $queueAlias;
    }
}
