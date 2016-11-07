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

use Build\Core\Module\Registrar;

class ModulesServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->app['modules']->register();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('modules', Registrar::class);
    }
}