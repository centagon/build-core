<?php

namespace Build\Core;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Support\Context;
use Build\Core\Http\Routing\Discovery;
use Build\Core\Providers\MenuServiceProvider;
use Build\Core\Providers\EventServiceProvider;
use Build\Core\Providers\AlertServiceProvider;
use Build\Core\Providers\ColorServiceProvider;
use Build\Core\Providers\RouteServiceProvider;
use Build\Core\Providers\AssetServiceProvider;
use Build\Core\Providers\PolicyServiceProvider;
use Build\Core\Providers\ModulesServiceProvider;
use Build\Core\Providers\RoutingServiceProvider;
use Build\Core\Providers\ConsoleServiceProvider;
use Build\Core\Providers\BauhausServiceProvider;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/core.php' => config_path('core.php')
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations')
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/core')
        ], 'views');

        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/build/core'),
        ], 'public');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'build.core');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'build.core');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/core.php', 'build.core');

        $this->registerProviders();
        $this->registerAliases();
        $this->registerHelpers();
    }

    /**
     * Register the required Build service providers.
     */
    protected function registerProviders()
    {
        $this->app->register(BauhausServiceProvider::class);
        $this->app->register(RoutingServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(ModulesServiceProvider::class);
        $this->app->register(PolicyServiceProvider::class);
        $this->app->register(ColorServiceProvider::class);
        $this->app->register(AlertServiceProvider::class);
        $this->app->register(AssetServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(MenuServiceProvider::class);
    }

    /**
     * Register the Build aliases.
     * @deprecated 2.0.0
     */
    protected function registerAliases()
    {
        $this->app->singleton('build.cms.discovery', Discovery::class);
        $this->app->singleton('build.context', Context::class);
    }

    /**
     * Include the helpers file.
     */
    protected function registerHelpers()
    {
        require __DIR__ . '/helpers.php';
    }
}
