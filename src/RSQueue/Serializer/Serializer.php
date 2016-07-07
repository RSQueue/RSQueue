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

namespace RSQueue\Serializer;

/**
 * Interface for any kind of serialization.
 *
 * This class must implements two methods, one for serialize data and another for unserialize it.
 */
interface Serializer
{
    /**
     * Given any kind of object, apply serialization.
     *
     * @param mixed $unserializedData
     *
     * @return string
     */
    public function apply($unserializedData) : string;

    /**
     * Given any kind of object, apply serialization.
     *
     * @param string $serializedData
     *
     * @return mixed
     */
    public function revert(string $serializedData);
}
