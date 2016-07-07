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

use RSQueue\Serializer\JsonSerializer;

/**
 * Tests JsonSerializer class.
 */
class JsonSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests json serializer apply method.
     */
    public function testApply()
    {
        $serializer = new JsonSerializer();
        $data = [
            'foo' => 'foodata',
            'engonga' => 'someengongadata',
        ];
        $serializedData = $serializer->apply($data);
        $this->assertEquals($serializedData, '{"foo":"foodata","engonga":"someengongadata"}');
    }

    /**
     * Test json serializer revert method.
     */
    public function testRevert()
    {
        $serializer = new JsonSerializer();
        $data = '{"foo":"foodata","engonga":"someengongadata"}';
        $unserializedData = $serializer->revert($data);
        $this->assertEquals($unserializedData, [
            'foo' => 'foodata',
            'engonga' => 'someengongadata',
        ]);
    }
}
