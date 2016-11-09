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

use Build\Core\Support\Menu;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Authenticated;

class MenuServiceProvider extends ServiceProvider
{

    protected $booted = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('build.menu', Menu::class);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        /**
         * @see https://github.com/laravel/framework/issues/15072
         */
        Event::listen(Authenticated::class, function () {
            if (! $this->booted) {
                $this->booted = true;

                require_once __DIR__ . '/../menu.php';
            }
        });
    }
}
