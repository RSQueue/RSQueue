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

namespace RSQueue\Command;

use Redis;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use RSQueue\Command\Abstracts\AbstractRSQueueCommand;
use RSQueue\Exception\MethodNotFoundException;
use RSQueue\Serializer\Serializer;

/**
 * Abstract PSubscriber command.
 *
 * Events :
 *
 * Events :
 *
 *     Each time a psubscriber recieves a new element, this throws a new
 *     rsqueue.psubscriber Event
 *
 * Exceptions :
 *
 *     If any ot inserted associated methods does not exist or is not
 *     callable, a new MethodNotFoundException will be thrown
 */
abstract class PSubscriberCommand extends AbstractRSQueueCommand
{
    /**
     * @var Serializer
     *
     * Serializer
     */
    private $serializer;

    /**
     * @var Redis
     *
     * Redis
     */
    private $redis;

    /**
     * PSubscriberCommand constructor.
     *
     * @param Serializer         $serializer
     * @param Redis|RedisCluster $redis
     */
    public function __construct(
        Serializer $serializer,
        $redis
    ) {
        parent::__construct();

        $this->serializer = $serializer;
        $this->redis = $redis;
    }

    /**
     * Adds a pattern to subscribe on.
     *
     * Checks if channel assigned method exists and is callable
     *
     * @param string $pattern       Pattern
     * @param string $patternMethod Pattern method
     *
     * @return SubscriberCommand self Object
     *
     * @throws MethodNotFoundException If any method is not callable
     */
    protected function addPattern($pattern, $patternMethod)
    {
        return $this->addMethod($pattern, $patternMethod);
    }

    /**
     * Execute code.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return int
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) : int {
        $this->define();

        $patterns = array_keys($this->methods);

        if ($this->shuffleQueues()) {
            shuffle($patterns);
        }

        $this
            ->redis
            ->psubscribe($patterns,
                function ($redis, $pattern, $channel, $payloadSerialized) use ($input, $output) {

                $payload = $this->serializer->revert($payloadSerialized);
                $method = $this->methods[$pattern];

                /*
                 * All custom methods must have these parameters
                 *
                 * InputInterface  $input   An InputInterface instance
                 * OutputInterface $output  An OutputInterface instance
                 * Mixed           $payload Payload
                 */
                $this->$method($input, $output, $payload);
            });

        $this->beforeDie();

        return 0;
    }
}
