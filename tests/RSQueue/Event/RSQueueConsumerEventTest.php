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

namespace RSQueue\Tests\Event;

use Redis;

use RSQueue\Event\RSQueueConsumerEvent;

/**
 * Tests RSQueueConsumerEvent class.
 */
class RSQueueConsumerEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RSQueueConsumerEvent
     *
     * Object to test
     */
    private $rsqueueConsumerEvent;

    /**
     * @var array
     *
     * Payload for testing
     */
    private $payload = [
        'foo' => 'foodata',
        'engonga' => 'someengongadata',
    ];

    /**
     * @var string
     *
     * Payload serialized
     */
    private $payloadSerialized = '{"foo":"foodata","engonga":"someengongadata"}';

    /**
     * @var string
     *
     * Queue Alias
     */
    private $queueAlias = 'queueAlias';

    /**
     * @var string
     *
     * Queue Name
     */
    private $queueName = 'queueName';

    /**
     * @var Redis
     *
     * Redis mock instance
     */
    private $redis;

    /**
     * Setup.
     */
    public function setUp()
    {
        $this->redis = $this->createMock('\Redis');
        $this->rsqueueConsumerEvent = new RSQueueConsumerEvent(
            $this->payload,
            $this->payloadSerialized,
            $this->queueAlias,
            $this->queueName,
            $this->redis
        );
    }

    /**
     * Testing payload getter.
     */
    public function testGetPayload()
    {
        $this->assertEquals(
            $this->rsqueueConsumerEvent->getPayload(),
            $this->payload
        );
    }

    /**
     * Testing payload serialized getter.
     */
    public function testGetPayloadSerialized()
    {
        $this->assertEquals(
            $this->rsqueueConsumerEvent->getPayloadSerialized(),
            $this->payloadSerialized
        );
    }

    /**
     * Testing queuename getter.
     */
    public function testGetQueueName()
    {
        $this->assertEquals(
            $this->rsqueueConsumerEvent->getQueueName(),
            $this->queueName
        );
    }

    /**
     * Testing queuealias getter.
     */
    public function testGetQueueAlias()
    {
        $this->assertEquals(
            $this->rsqueueConsumerEvent->getQueueAlias(),
            $this->queueAlias
        );
    }

    /**
     * Testing Redis getter.
     */
    public function testGetRedis()
    {
        $this->assertSame(
            $this->rsqueueConsumerEvent->getRedis(),
            $this->redis
        );
    }
}
