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

namespace RSQueue\Tests\Event;

use Redis;
use RSQueue\Event\RSQueueProducerEvent;

/**
 * Tests RSQueueProducerEvent class.
 */
class RSQueueProducerEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RSQueueProducerEvent
     *
     * Object to test
     */
    private $rsqueueProducerEvent;

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
        $this->rsqueueProducerEvent = new RSQueueProducerEvent(
            $this->payload,
            $this->payloadSerialized,
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
            $this->rsqueueProducerEvent->getPayload(),
            $this->payload
        );
    }

    /**
     * Testing payload serialized getter.
     */
    public function testGetPayloadSerialized()
    {
        $this->assertEquals(
            $this->rsqueueProducerEvent->getPayloadSerialized(),
            $this->payloadSerialized
        );
    }

    /**
     * Testing queuename getter.
     */
    public function testGetQueueName()
    {
        $this->assertEquals(
            $this->rsqueueProducerEvent->getQueueName(),
            $this->queueName
        );
    }

    /**
     * Testing Redis getter.
     */
    public function testGetRedis()
    {
        $this->assertSame(
            $this->rsqueueProducerEvent->getRedis(),
            $this->redis
        );
    }
}
