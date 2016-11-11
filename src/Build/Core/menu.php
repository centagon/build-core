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
use Build\Core\Support\Facades\Discovery;

createLeftMenu(Menu::get('build.header-left'));
createRightMenu(Menu::get('build.header-right'));

function createLeftMenu($menu)
{
    $menu->add('Structure');
    $menu->add('Design');
    $menu->add('Content');
    $menu->add('Processes');
    $menu->add('Administration');

    $menu->structure->add('Websites', route('admin.websites.index'));
    $menu->structure->add('Groups', '#');

    $menu->design->add('Colors', route('admin.colors.index'));
    $menu->design->add('Assets', '#');

    $menu->content->add('Language', route('admin.languages.index'));
    $menu->content->add('Downloads', '#');

    $menu->processes->add('Selectables', '#');

    $menu->administration->add('Queue', '#');
    $menu->administration->add('Modules', route('admin.modules.index'));

    return $menu;
}

function createRightMenu($menu)
{
    if ($currentSite = Discovery::backendWebsite()) {
        $siteMenu = $menu->add($currentSite->name, route('admin.springboard.open', $currentSite->getKey()));

        foreach (Discovery::userWebsites() as $site) {
            if ($site->getKey() == $currentSite->getKey()) {
                continue;
            }

            $siteMenu->add($site->name, route('admin.springboard.open', $site->getKey()));
        }
    }

    $menu->add('User management', route('admin.users.index'))
        ->data('permission', 'index-user');

    $menu->add('Sign-out', route('admin.sessions.destroy'));

    return $menu;
}
