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

namespace RSQueue\Tests\Resolver;

use RSQueue\Resolver\QueueAliasResolver;

/**
 * Tests QueueAliasResolver class.
 */
class QueueAliasResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     *
     * Queue aliases setup
     */
    private $queues = [
        'myqueue1' => 'queues.myqueue1',
        'myqueue2' => 'queues.myqueue2',
    ];

    /**
     * Tests get queue method.
     */
    public function testGetQueues()
    {
        $queueAliasResolver = new QueueAliasResolver($this->queues);
        $this->assertEquals($queueAliasResolver->getQueues(array_keys($this->queues)), array_values($this->queues));
    }

    /**
     * Tests get queue method.
     */
    public function testGetQueue()
    {
        $queueAliasResolver = new QueueAliasResolver($this->queues);
        $this->assertEquals($queueAliasResolver->getQueue('myqueue1'), $this->queues['myqueue1']);
        $this->assertEquals($queueAliasResolver->getQueue('myqueue2'), $this->queues['myqueue2']);
        $this->assertEquals($queueAliasResolver->getQueue('myqueue3'), 'myqueue3');
    }

    /**
     * Tests get queue alias by queue name.
     */
    public function testGetQueueAliasByQueueName()
    {
        $queueAliasResolver = new QueueAliasResolver($this->queues);
        $this->assertEquals($queueAliasResolver->getQueueAliasByQueueName($this->queues['myqueue1']), 'myqueue1');
        $this->assertEquals($queueAliasResolver->getQueueAliasByQueueName('myqueue3'), 'myqueue3');
    }
}
