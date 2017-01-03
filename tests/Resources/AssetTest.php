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
use Build\Core\Resources\Assets\Group;
use Build\Core\Tests\AbstractTestCase;

class AssetTest extends AbstractTestCase
{

    function test_can_create_new_empty_group()
    {
        $group = Asset::make('my-group');

        $this->assertEquals(Group::class, get_class($group));
        $this->assertEmpty($group->js());
        $this->assertEmpty($group->css());
    }

    function test_can_add_css()
    {
        $group = Asset::make('my-css-group')->add('test.css');

        $this->assertInternalType('string', $group->css());
        $this->assertNotEmpty($group->css());
        $this->assertEmpty($group->js());

        $this->assertEquals('<link rel="stylesheet" href="test.css">
', $group->css());
    }

    function test_can_add_js()
    {
        $group = Asset::make('my-js-group')->add('test.js');

        $this->assertInternalType('string', $group->js());
        $this->assertNotEmpty($group->js());
        $this->assertEmpty($group->css());

        $this->assertEquals('<script type="text/javascript" src="test.js"></script>
', $group->js());
    }

    function test_can_add_dependency()
    {
        $group = Asset::make('my-js-group');
        $group->add('test1.js', 'test1')->dependsOn('test2');
        $group->add('test2.js', 'test2');

        $this->assertEquals('<script type="text/javascript" src="test2.js"></script>
<script type="text/javascript" src="test1.js"></script>
', $group->js());
    }
}