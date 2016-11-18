<?php

namespace Build\Core\Tests\Eloquent\Models;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\Color;
use Build\Core\Tests\AbstractTestCase;

class ColorTest extends AbstractTestCase
{

    public function test_can_create_color()
    {
        $color = new Color(['name' => 'test', 'color' => 'red']);
        $color->save();

        $this->assertTrue(true);
    }
}