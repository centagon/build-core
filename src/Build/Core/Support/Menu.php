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
}