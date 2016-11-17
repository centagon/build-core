<?php

namespace Build\Core\Tests\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Support\Color;
use Build\Core\Tests\AbstractTestCase;

class ColorTest extends AbstractTestCase
{

    public function test_best_contrast()
    {
        $this->assertEquals(Color::bestContrast('#ff0000'), 'white');
        $this->assertEquals(Color::bestContrast('#00ff00'), 'black');
        $this->assertEquals(Color::bestContrast('#0000ff'), 'white');
    }

    public function test_is_rgb()
    {
        $rgb = 'rgb(0, 0, 0)';
        $notRgb = '#000';

        $this->assertTrue(Color::isRgb($rgb));
        $this->assertFalse(Color::isRgb($notRgb));
    }

    public function test_is_hex()
    {
        $hex = '#000';
        $notHex = 'rgb(0, 0, 0)';

        $this->assertTrue(Color::isHex($hex));
        $this->assertFalse(Color::isHex($notHex));
    }

    public function test_to_rgb()
    {
        $this->assertEquals(Color::toRgb('#04f'), 'rgb(0, 68, 255)');
        $this->assertEquals(Color::toRgb('#0044ff'), 'rgb(0, 68, 255)');
        $this->assertEquals(Color::toRgb('rgb(0, 68, 255)'), 'rgb(0, 68, 255)');
    }

    public function test_to_rgb_array()
    {
        $rgb = 'rgb(0, 10, 200)';

        $this->assertEquals(Color::toRgbArray($rgb), [
            'r' => 0,
            'g' => 10,
            'b' => 200
        ]);
    }

    public function test_to_hex()
    {
        $this->assertEquals(Color::toHex('rgb(0, 10, 200)'), '#000ac8');
        $this->assertEquals(Color::toHex('#000ac8'), '#000ac8');
    }
}