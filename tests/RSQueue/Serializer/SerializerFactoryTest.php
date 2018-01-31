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

namespace RSQueue\Tests\Serializer;

use RSQueue\Exception\SerializerNotFoundException;
use RSQueue\Exception\SerializerNotImplementsInterfaceException;
use RSQueue\Serializer\SerializerFactory;

/**
 * Tests SerializerFactory class.
 */
class SerializerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests PHP serializer load.
     */
    public function testPHPGet()
    {
        $serializerFactory = new SerializerFactory('PHP');
        $this->assertInstanceOf('\\RSQueue\\Serializer\\PHPSerializer', $serializerFactory->create());
    }

    /**
     * Tests Json serializer load.
     */
    public function testJsonGet()
    {
        $serializerFactory = new SerializerFactory('Json');
        $this->assertInstanceOf('\\RSQueue\\Serializer\\JsonSerializer', $serializerFactory->create());
    }

    /**
     * Tests class or type not found.
     */
    public function testSerializerNotFound()
    {
        $serializerFactory = new SerializerFactory('\\RSQueue\\Tests\\Factory\\Serializer\\EngongaSerializer');

        try {
            $serializerFactory->create();
        } catch (SerializerNotFoundException $expected) {
            return;
        }

        $this->fail('An expected SerializerNotFoundException exception has not been raised.');
    }

    /**
     * Tests class found with not implementation of SerializerInterface.
     */
    public function testSimpleNotImplementingInterfaceFound()
    {
        $serializerFactory = new SerializerFactory('\\RSQueue\\Serializer\\PHPSerializer');
        $this->assertInstanceOf('\\RSQueue\\Serializer\\PHPSerializer', $serializerFactory->create());
    }

    /**
     * Tests class found with not implementation of SerializerInterface.
     */
    public function testNotImplementingInterfaceFound()
    {
        $serializerFactory = new SerializerFactory('\\RSQueue\\Tests\\Serializer\\Serializer\\FooSerializer');

        try {
            $serializerFactory->create();
        } catch (SerializerNotImplementsInterfaceException $expected) {
            return;
        }

        $this->fail('An expected SerializerNotImplementsInterfaceException exception has not been raised.');
    }
}
