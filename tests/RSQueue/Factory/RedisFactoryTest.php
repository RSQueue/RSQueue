<?php
/**
 * Created by PhpStorm.
 * User: pilou
 * Date: 04/12/16
 * Time: 21:57
 */

namespace RSQueue\tests\RSQueue\Factory;


use RSQueue\Factory\RedisFactory;
use RSQueue\Redis\PredisClientAdapter;
use RSQueue\Redis\RedisAdapter;

class RedisFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testGetPHPRedisDriver()
    {
        $config = [
            'driver'=>'phpredis',
            'host'=>'my_host',
            'port'=>8888,
            'database'=>5
        ];

        $redisFactory = $this->getMockBuilder(RedisFactory::class)
            ->setConstructorArgs([$config])
            ->setMethods(['getPHPRedisClient'])
            ->getMock();

        $redisFactory->expects($this->once())
            ->method('getPHPRedisClient')
            ->with($config);

        $this->assertInstanceOf(RedisAdapter::class,$redisFactory->get());

    }

    public function testGetPredisDriver()
    {
        $config = [
            'driver'=>'predis',
            'host'=>'my_host',
            'port'=>8888,
            'database'=>5
        ];

        $redisFactory = $this->getMockBuilder(RedisFactory::class)
            ->setConstructorArgs([$config])
            ->setMethods(['getPredisClient'])
            ->getMock();

        $redisFactory->expects($this->once())
            ->method('getPredisClient')
            ->with($config);

        $this->assertInstanceOf(PredisClientAdapter::class,$redisFactory->get());

    }

    /**
     * @expectedException \RSQueue\Exception\UnknownDriverException
     */
    public function testGetUnknownDriver()
    {
        $config = [
            'driver'=>'Rediska',
            'host'=>'my_host',
            'port'=>8888,
            'database'=>5
        ];

        $redisFactory = new RedisFactory($config);
        $redisFactory->get();

    }

}