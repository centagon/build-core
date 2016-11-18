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
        $color = $this->getColor();
        $color->save();

        $this->assertEquals($color->name, 'my-dark-color');
        $this->assertEquals($color->color, '#000000');
    }

    public function test_can_convert_to_hex()
    {
        $color = $this->getColor();
        $color->save();

        $this->assertEquals($color->hex_color, '#000000');
    }

    public function test_can_convert_to_rgb()
    {
        $color = $this->getColor();
        $color->save();

        $this->assertEquals($color->rgb_color, 'rgb(0, 0, 0)');
    }

    public function test_can_get_best_contrast()
    {
        $color = $this->getColor();
        $color->save();

        $this->assertEquals($color->best_contrast, 'white');
    }

    protected function getColor()
    {
        return new Color([
            'name' => 'My Dark Color',
            'color' => '#000000',
        ]);
    }
}