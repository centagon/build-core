<?php

namespace Build\Core\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Menu
{

    protected $menu;

    public function __construct()
    {
        $this->menu = new \Lavary\Menu\Menu;
    }

    public function load($filename)
    {
        if (! file_exists($filename)) {
            throw new \RuntimeException('Unable to load ' . $filename);
        }

        require $filename;
    }

    public function get($position)
    {
        if ($menu = $this->menu->get($position)) {
            return $menu;
        }

        // No previously defined menu has been found
        // so we'll go ahead and create one now.
        return $this->menu->make($position, function () {
            return null;
        });
    }

    public function adjust()
    {
        if (! app()->bound('build.cms.discovery')) {
            return;
        }

        $websites = app('build.cms.discovery')->discoverUserWebsites();

        if (count($websites) < 2) {
            return;
        }

        $order = [
            'userManagement' => 1,
            'myWebsites' => 2,
            'signOut' => 3,
        ];

        // Attach 'my websites' to the right topbar.
        if (app('build.cms.discovery')->discoverBackendWebsite()) {
            $name = app('build.cms.discovery')->discoverBackendWebsite()->name;
        } else {
            $name = 'website';
        }

        $base = app('build.menu')->get('build.header-right')->add($name);

        // Sort the right topbar items
        foreach (app('build.menu')->get('build.header-right')->items as $key => $value) {
            if (isset($order[$value->nickname])) {
                $value->data('order', $order[$value->nickname]);
            }
        }

        $this->menu->get('build.header-right')->sortBy('order');

        foreach ($websites as $key => $website) {
            $base->add($website->name, build_route('cms.backendsessions.swap', $website->getKey()));
        }
    }
}