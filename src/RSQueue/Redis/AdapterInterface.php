<?php
namespace RSQueue\Redis;

/**
 * Interface AdapterInterface
 * @package RSQueue\Redis
 */
interface AdapterInterface
{

    /**
     * @param $queues
     * @param $timeout
     * @return mixed
     */
    public function blPop($queues, $timeout);

    /**
     * @param $key
     * @param array $messages
     * @return mixed
     */
    public function rPush($key, array $messages);

    /**
     * @param $channels
     * @param $callback
     */
    public function subscribe($channels, $callback);

    /**
     * @param $patterns
     * @param $callback
     */
    public function psubscribe($patterns, $callback);

    /**
     * @param $channel
     * @param $message
     * @return mixed
     */
    public function publish($channel, $message);

    /**
     * @return \Redis|\Predis\Client
     */
    public function getClient();

}