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

namespace RSQueue\Factory;

use RSQueue\Exception\SerializerNotFoundException;
use RSQueue\Exception\SerializerNotImplementsInterfaceException;
use RSQueue\Serializer\Serializer;

/**
 * Interface for any kind of serialization.
 */
class SerializerFactory
{
    /**
     * @var Serializer
     *
     * Serializer
     */
    protected $serializerType;

    /**
     * Construct method.
     *
     * @param string $serializerType
     */
    public function __construct(string $serializerType)
    {
        $this->serializerType = $serializerType;
    }

    /**
     * Generate new Serializer.
     *
     * @return Serializer Generated Serializer
     *
     * @throws SerializerNotFoundException
     * @throws SerializerNotImplementsInterfaceException
     */
    public function get()
    {
        if (class_exists($this->serializerType)) {
            if (in_array('RSQueue\\Serializer\\Serializer', class_implements($this->serializerType))) {
                return new $this->serializerType();
            } else {
                throw new SerializerNotImplementsInterfaceException();
            }
        }

        $composedSerializerNamespace = '\\RSQueue\\Serializer\\' . $this->serializerType . 'Serializer';

        if (class_exists($composedSerializerNamespace)) {
            return new $composedSerializerNamespace();
        }

        throw new SerializerNotFoundException();
    }
}
