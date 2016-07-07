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

use RSQueue\Event\RSQueuePublisherEvent;

/**
 * Tests RSChannelPublisherEvent class.
 */
class RSQueuePublisherEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RSQueuePublisherEvent
     *
     * Object to test
     */
    private $rsqueuePublisherEvent;

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
     * Channel Alias
     */
    private $channelAlias = 'channelAlias';

    /**
     * @var string
     *
     * Channel Name
     */
    private $channelName = 'channelName';

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
        $this->rsqueuePublisherEvent = new RSQueuePublisherEvent(
            $this->payload,
            $this->payloadSerialized,
            $this->channelAlias,
            $this->channelName,
            $this->redis
        );
    }

    /**
     * Testing payload getter.
     */
    public function testGetPayload()
    {
        $this->assertEquals(
            $this->rsqueuePublisherEvent->getPayload(),
            $this->payload
        );
    }

    /**
     * Testing payload serialized getter.
     */
    public function testGetPayloadSerialized()
    {
        $this->assertEquals(
            $this->rsqueuePublisherEvent->getPayloadSerialized(),
            $this->payloadSerialized
        );
    }

    /**
     * Testing channelname getter.
     */
    public function testGetChannelName()
    {
        $this->assertEquals(
            $this->rsqueuePublisherEvent->getChannelName(),
            $this->channelName
        );
    }

    /**
     * Testing channelalias getter.
     */
    public function testGetChannelAlias()
    {
        $this->assertEquals(
            $this->rsqueuePublisherEvent->getChannelAlias(),
            $this->channelAlias
        );
    }

    /**
     * Testing Redis getter.
     */
    public function testGetRedis()
    {
        $this->assertSame(
            $this->rsqueuePublisherEvent->getRedis(),
            $this->redis
        );
    }
}
