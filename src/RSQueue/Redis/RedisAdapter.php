<?php
namespace RSQueue\Redis;

/**
 * Class RedisAdapter
 * @package RSQueue\Redis
 */
class RedisAdapter implements AdapterInterface
{
    /**
     * @var \Redis
     */
    protected $client;

    /**
     * RedisAdapter constructor.
     * @param \Redis $redis
     */
    public function __construct(\Redis $redis)
    {
        $this->client = $redis;
    }

    /**
     * @param $queues
     * @param $timeout
     * @return array
     */
    public function blPop($queues, $timeout)
    {
        return $this->client->blPop($queues, $timeout);
    }

    /**
     * @param $key
     * @param array $messages
     * @return int
     */
    public function rPush($key, array $messages)
    {
        return $this->client->rPush($key, $messages);
    }

    /**
     * @param $channels
     * @param $callback
     */
    public function subscribe($channels, $callback)
    {
        $this->client->subscribe($channels, $callback);
    }

    /**
     * @param $patterns
     * @param $callback
     */
    public function psubscribe($patterns, $callback)
    {
        $this->client->psubscribe($patterns, $callback);
    }

    /**
     * @param $channel
     * @param $message
     * @return int|mixed
     */
    public function publish($channel, $message)
    {
       return $this->client->publish($channel, $message);
    }

    /**
     * @return \Redis
     */
    public function getClient()
    {
        return $this->client;
    }


}