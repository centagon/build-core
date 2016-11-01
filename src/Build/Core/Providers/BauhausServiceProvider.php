<?php

namespace Build\Core\Providers;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Bauhaus\Widgets;
use Build\Core\Bauhaus\Support\Container;

class BauhausServiceProvider extends \Illuminate\Support\ServiceProvider
{

    protected $widgets = [
        'table' => Widgets\Data\Table::class,
        'content.icon' => Widgets\Content\Icon::class,
        'content.heading' => Widgets\Content\Heading::class,
        'navigation.link' => Widgets\Navigation\Link::class,
        'navigation.button' => Widgets\Navigation\Button::class
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('build.bauhaus.container', Container::class);

        app('build.bauhaus.container')->register($this->widgets);
    }
}