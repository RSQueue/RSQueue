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

namespace RSQueue\Tests\Services;

use RSQueue\Services\Consumer;

/**
 * Tests Consumer class.
 */
class ConsumerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests consume method.
     */
    public function testConsume()
    {
        $queueAlias = 'alias';
        $queue = 'queue';
        $timeout = 0;
        $payload = ['engonga'];

        $redis = $this
            ->createMock('\Redis', ['blPop']);

        $redis
            ->expects($this->once())
            ->method('blPop')
            ->with($this->equalTo($queue), $this->equalTo($timeout))
            ->will($this->returnValue([$queue, json_encode($payload)]));

        $serializer = $this
            ->createMock('RSQueue\Serializer\JsonSerializer', ['revert']);

        $serializer
            ->expects($this->once())
            ->method('revert')
            ->with($this->equalTo(json_encode($payload)))
            ->will($this->returnValue($payload));

        $queueAliasResolver = $this
            ->getMockBuilder('RSQueue\Resolver\QueueAliasResolver')
            ->setMethods(['getQueue', 'getQueueAlias'])
            ->disableOriginalConstructor()
            ->getMock();

        $queueAliasResolver
            ->expects($this->once())
            ->method('getQueue')
            ->with($this->equalTo($queueAlias))
            ->will($this->returnValue($queue));

        $queueAliasResolver
            ->expects($this->once())
            ->method('getQueueAlias')
            ->with($this->equalTo($queue))
            ->will($this->returnValue($queueAlias));

        $eventDispatcher = $this
            ->createMock('Symfony\Component\EventDispatcher\EventDispatcher', ['dispatch']);

        $eventDispatcher
            ->expects($this->once())
            ->method('dispatch');

        $consumer = new Consumer($eventDispatcher, $redis, $queueAliasResolver, $serializer);
        list($givenQueueAlias, $givenPayload) = $consumer->consume($queueAlias, $timeout);

        $this->assertEquals($queueAlias, $givenQueueAlias);
        $this->assertEquals($payload, $givenPayload);
    }
}
