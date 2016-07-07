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

use RSQueue\Event\RSQueueSubscriberEvent;

/**
 * Tests RSChannelSubscriberEvent class.
 */
class RSQueueSubscriberEventTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RSQueueSubscriberEvent
     *
     * Object to test
     */
    private $rsqueueSubscriberEvent;

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
        $this->rsqueueSubscriberEvent = new RSQueueSubscriberEvent(
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
            $this->rsqueueSubscriberEvent->getPayload(),
            $this->payload
        );
    }

    /**
     * Testing payload serialized getter.
     */
    public function testGetPayloadSerialized()
    {
        $this->assertEquals(
            $this->rsqueueSubscriberEvent->getPayloadSerialized(),
            $this->payloadSerialized
        );
    }

    /**
     * Testing channelname getter.
     */
    public function testGetChannelName()
    {
        $this->assertEquals(
            $this->rsqueueSubscriberEvent->getChannelName(),
            $this->channelName
        );
    }

    /**
     * Testing channelalias getter.
     */
    public function testGetChannelAlias()
    {
        $this->assertEquals(
            $this->rsqueueSubscriberEvent->getChannelAlias(),
            $this->channelAlias
        );
    }

    /**
     * Testing Redis getter.
     */
    public function testGetRedis()
    {
        $this->assertSame(
            $this->rsqueueSubscriberEvent->getRedis(),
            $this->redis
        );
    }
}
