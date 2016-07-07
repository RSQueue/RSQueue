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

namespace RSQueue\Command\Abstracts;

use Symfony\Component\Console\Command\Command;

use RSQueue\Command\Interfaces\RSQueueCommandInterface;
use RSQueue\Exception\MethodNotFoundException;

/**
 * Abstract rs queue command.
 */
abstract class AbstractRSQueueCommand extends Command implements RSQueueCommandInterface
{
    /**
     * @var array
     *
     * Array with all configured queues/ with their callable methods
     */
    protected $methods = [];

    /**
     * Adds a queue/channel to subscribe on.
     *
     * Checks if queue assigned method exists and is callable
     *
     * @param string $alias  Queue alias
     * @param string $method Queue method
     *
     * @return AbstractRSQueueCommand self Object
     *
     * @throws MethodNotFoundException If any method is not callable
     */
    protected function addMethod($alias, $method)
    {
        if (!is_callable([$this, $method])) {
            throw new MethodNotFoundException($alias);
        }

        $this->methods[$alias] = $method;

        return $this;
    }

    /**
     * Set automatic queue mixing when several queues are defined.
     *
     * This method returns if queue order must be shuffled before processing them
     *
     * By default is false, so same order will be passed as defined.
     *
     * @return bool Shuffle before passing to Gearman
     */
    protected function shuffleQueues()
    {
        return false;
    }
}
