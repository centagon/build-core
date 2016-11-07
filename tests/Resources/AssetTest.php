<?php

namespace Build\Core\Tests\Resources;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Support\Facades\Asset;
use Build\Core\Tests\AbstractTestCase;

class AssetTest extends AbstractTestCase
{

    function test_empty_stylesheet_on_initial_load()
    {
        $this->assertEmpty(Asset::styles());
    }

    function test_empty_javascripts_on_initial_load()
    {
        $this->assertEmpty(Asset::scripts());
    }

    function test_can_add_style_reference()
    {
        Asset::addStylesheet('test.css');

        // Assert that the stack is empty.
        $this->assertNotEmpty(Asset::styles());

        // Assert sure that we've added 1 stylesheet to the stack.
        $this->assertCount(1, explode("\n", Asset::styles()));

        // Determine that the string equals what we expected.
        $this->assertEquals('<link rel="stylesheet" href="test.css" />', Asset::styles());

        Asset::addStylesheet('another.css');

        // We've added another style, so we should get two lines now.
        $this->assertCount(2, explode("\n", Asset::styles()));
        $this->assertEquals('<link rel="stylesheet" href="test.css" />
<link rel="stylesheet" href="another.css" />', Asset::styles());
    }

    function test_can_add_inline_styles()
    {
        $style = 'body { background: red; }';

        // Assert that the stack is empty.
        $this->assertEmpty(Asset::styles());

        Asset::inlineStyle($style);

        $this->assertNotEmpty(Asset::styles());
        $this->assertEquals(Asset::styles(), '<style>' . $style . '</style>');
    }
}