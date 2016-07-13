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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use RSQueue\Command\Abstracts\AbstractRSQueueCommand;
use RSQueue\Exception\MethodNotFoundException;
use RSQueue\Services\Consumer;

/**
 * Abstract consumer command.
 *
 * Events :
 *
 *     Each time a consumer recieves a new element, this throws a new
 *     rsqueue.consumer Event
 *
 * Exceptions :
 *
 *     If any of inserted queues or channels is not defined in config file
 *     as an alias, a new InvalidAliasException will be thrown
 *
 *     Likewise, if any ot inserted associated methods does not exist or is not
 *     callable, a new MethodNotFoundException will be thrown
 */
abstract class ConsumerCommand extends AbstractRSQueueCommand
{
    /**
     * @var Consumer
     *
     * Consumer
     */
    private $consumer;

    /**
     * ConsumerCommand constructor.
     *
     * @param Consumer $consumer
     */
    public function __construct(Consumer $consumer)
    {
        parent::__construct();

        $this->consumer = $consumer;
    }

    /**
     * Adds a queue to subscribe on.
     *
     * Checks if queue assigned method exists and is callable
     *
     * @param string $queueAlias  Queue alias
     * @param string $queueMethod Queue method
     *
     * @return SubscriberCommand self Object
     *
     * @throws MethodNotFoundException If any method is not callable
     */
    protected function addQueue($queueAlias, $queueMethod)
    {
        return $this->addMethod($queueAlias, $queueMethod);
    }

    /**
     * Configure command.
     *
     * Some options are included
     * * timeout ( default: 0)
     * * iterations ( default: 0)
     * * sleep ( default: 0)
     *
     * Important !!
     *
     * All Commands with this consumer behaviour must call parent() configure method
     */
    protected function configure()
    {
        $this
            ->addOption(
                'timeout',
                null,
                InputOption::VALUE_OPTIONAL,
                'Consumer timeout.
                If 0, no timeout is set.
                Otherwise consumer will lose conection after timeout if queue is empty.
                By default, 0',
                0
            )
            ->addOption(
                'iterations',
                null,
                InputOption::VALUE_OPTIONAL,
                'Number of iterations before this command kills itself.
                If 0, consumer will listen queue until process is killed by hand or by exception.
                You can manage this behavour by using some Process Control System, e.g. Supervisord
                By default, 0',
                0
            )
            ->addOption(
                'sleep',
                null,
                InputOption::VALUE_OPTIONAL,
                'Timeout between each iteration ( in seconds ).
                If 0, no time will be waitted between them.
                Otherwise, php will sleep X seconds each iteration.
                By default, 0',
                0
            );
    }

    /**
     * Execute code.
     *
     * Each time new payload is consumed from queue, consume() method is called.
     * When iterations get the limit, process literaly dies
     *
     * @param  InputInterface  $input  An InputInterface instance
     * @param  OutputInterface $output An OutputInterface instance
     *                                  
     * @return int
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) : int {
        $this->define();

        $iterations = (int) $input->getOption('iterations');
        $timeout = (int) $input->getOption('timeout');
        $sleep = (int) $input->getOption('sleep');
        $iterationsDone = 0;
        $queuesAlias = array_keys($this->methods);

        if ($this->shuffleQueues()) {
            shuffle($queuesAlias);
        }

        while ($response = $this
            ->consumer
            ->consume(
                $queuesAlias,
                $timeout
            )
        ) {
            list($queueAlias, $payload) = $response;
            $method = $this->methods[$queueAlias];

            /*
             * All custom methods must have these parameters
             *
             * InputInterface  $input   An InputInterface instance
             * OutputInterface $output  An OutputInterface instance
             * Mixed           $payload Payload
             */
            $this->$method($input, $output, $payload);

            if (($iterations > 0) && (++$iterationsDone >= $iterations)) {
                break;
            }

            sleep($sleep);
        }

        return 0;
    }
}
