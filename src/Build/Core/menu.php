<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Support\Facades\Menu;

$left = createLeftMenu(Menu::get('build.header-left'));
$right = createRightMenu(Menu::get('build.header-right'));

function createLeftMenu($menu)
{
    $menu->add('Structure');
    $menu->add('Design');
    $menu->add('Content');
    $menu->add('Processes');
    $menu->add('Administration');

    $menu->structure->add('Websites', route('admin.websites.index'));
    $menu->design->add('Colors');
    $menu->administration->add('Universe');

    return $menu;
}

function createRightMenu($menu)
{
    $menu->add('User management')->data('permission', 'index-user');
    $menu->add('Sign-out', route('admin.sessions.destroy'));

    return $menu;
}