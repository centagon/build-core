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

use Build\Core\Support\Facades\Menu;
use Build\Core\Tests\AbstractTestCase;

class MenuTest extends AbstractTestCase
{

    public function test_can_create_empty_menu()
    {
        $menu = Menu::get('test-menu');

        $this->assertEmpty($menu->items);
    }

    public function test_can_add_items()
    {
        $menu = Menu::get('test-menu');
        $menu->add('Item 1');

        $this->assertNotEmpty($menu->items);
        $this->assertCount(1, $menu->items);
    }
}