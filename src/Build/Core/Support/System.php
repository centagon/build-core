<?php

namespace Build\Core\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class System
{

    /**
     * Determine if we're running in 64 bits mode.
     *
     * @return bool
     */
    public static function is64Bits()
    {
        return strlen(decbin(~0)) == 64;
    }
}