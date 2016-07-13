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
            ->setMethods(['getQueue'])
            ->disableOriginalConstructor()
            ->getMock();

        $queueAliasResolver
            ->method('getQueue')
            ->with($this->equalTo($queue))
            ->will($this->returnValue($queue));

        $eventDispatcher = $this
            ->createMock('Symfony\Component\EventDispatcher\EventDispatcher', ['dispatch']);

        $eventDispatcher
            ->expects($this->once())
            ->method('dispatch');

        $consumer = new Consumer($eventDispatcher, $redis, $queueAliasResolver, $serializer);
        list($givenQueueAlias, $givenPayload) = $consumer->consume($queue, $timeout);

        $this->assertEquals($queue, $givenQueueAlias);
        $this->assertEquals($payload, $givenPayload);
    }
}
