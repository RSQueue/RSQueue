<?php

/*
 * This file is part of the RSQueue library
 *
 * Copyright (c) 2016 - now() Marc Morera
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

namespace RSQueue\Tests\Serializer;

use RSQueue\Serializer\PHPSerializer;

/**
 * Tests PHPSerializer class.
 */
class PHPSerializerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests php serializer apply method.
     */
    public function testApply()
    {
        $serializer = new PHPSerializer();
        $data = [
            'foo' => 'foodata',
            'engonga' => 'someengongadata',
        ];
        $serializedData = $serializer->apply($data);
        $this->assertEquals($serializedData, 'a:2:{s:3:"foo";s:7:"foodata";s:7:"engonga";s:15:"someengongadata";}');
    }

    /**
     * Test php serializer revert method.
     */
    public function testRevert()
    {
        $serializer = new PHPSerializer();
        $data = 'a:2:{s:3:"foo";s:7:"foodata";s:7:"engonga";s:15:"someengongadata";}';
        $unserializedData = $serializer->revert($data);
        $this->assertEquals($unserializedData, [
            'foo' => 'foodata',
            'engonga' => 'someengongadata',
        ]);
    }
}
