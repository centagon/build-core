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
    $menu
        ->add(trans('build.core::menu.structure'))
        ->nickname('structure');

    $menu->structure->add(trans('build.core::menu.structure.websites'), route('admin.websites.index'));
    $menu->structure->add(trans('build.core::menu.structure.groups'), '#');

    $menu
        ->add(trans('build.core::menu.design'))
        ->nickname('design');

    $menu->design->add(trans('build.core::menu.design.colors'), route('admin.colors.index'));
    $menu->design->add(trans('build.core::menu.design.assets'), '#');

    $menu
        ->add(trans('build.core::menu.content'))
        ->nickname('content');

    $menu->content->add(trans('build.core::menu.content.languages'), route('admin.languages.index'));
    $menu->languages->divide();

    $menu
        ->add(trans('build.core::menu.processes'))
        ->nickname('processes');

    $menu
        ->add(trans('build.core::menu.admin'))
        ->nickname('admin');

    $menu->admin->add(trans('build.core::menu.admin.modules'), route('admin.modules.index'));

    return $menu;
}

function createRightMenu($menu)
{
    if ($currentSite = Discovery::backendWebsite()) {
        $siteMenu = $menu->add($currentSite->name, route('admin.springboard.open', $currentSite->getKey()));

        $lastItem = null;

        foreach (Discovery::userWebsites() as $site) {
            if ($site->getKey() == $currentSite->getKey()) {
                continue;
            }

            $lastItem = $siteMenu->add($site->name, route('admin.springboard.open', $site->getKey()));
        }

        if ($lastItem !== null) {
            $lastItem->divide();

            $siteMenu->add('Springboard', route('admin.springboard.index'));
        }
    }

    $menu->add(trans('build.core::menu.users'), route('admin.users.index'))
        ->data('permission', 'index-user');

    $menu->add(trans('build.core::menu.sign-out'), route('admin.sessions.destroy'));

    return $menu;
}
