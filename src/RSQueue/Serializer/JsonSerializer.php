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

namespace RSQueue\Serializer;

/**
 * Implementation of Json Serializer.
 */
class JsonSerializer implements Serializer
{
    /**
     * Given any kind of object, apply serialization.
     *
     * @param mixed $unserializedData
     *
     * @return string
     */
    public function apply($unserializedData) : string
    {
        return json_encode($unserializedData);
    }

    /**
     * Given any kind of object, apply serialization.
     *
     * @param string $serializedData
     *
     * @return mixed
     */
    public function revert(string $serializedData)
    {
        return json_decode($serializedData, true);
    }
}
