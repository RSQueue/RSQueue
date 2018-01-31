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

namespace RSQueue\Exception;

use Exception;

/**
 * Name is not a valid queue name Exception.
 *
 * When queue name not belongs to any configured queue
 */
final class SerializerNotFoundException extends Exception
{
}
