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
use Build\Core\Support\Color as Support;

class ColorTest extends AbstractTestCase
{

    public function test_can_create_color()
    {
        $color = factory(Color::class)->make();

        $this->assertNotEmpty($color->name);
        $this->assertNotEmpty($color->color);
    }

    public function test_can_convert_to_hex()
    {
        $color = factory(Color::class)->make();

        $this->assertTrue(Support::isHex($color->hex_color));
    }

    public function test_can_convert_to_rgb()
    {
        $color = factory(Color::class)->make();

        $this->assertTrue(Support::isRgb($color->rgb_color));
    }

    public function test_can_get_best_contrast()
    {
        $color = factory(Color::class)->make();

        $this->assertInArray($color->best_contrast, [
            'black', 'white',
        ]);
    }
}