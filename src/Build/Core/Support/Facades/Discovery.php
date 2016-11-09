<?php

namespace Build\Core\Support\Facades;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Discovery extends \Illuminate\Support\Facades\Facade
{

    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'build.cms.discovery';
    }
}
