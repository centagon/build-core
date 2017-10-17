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

use Intervention\Image\ImageServiceProvider;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    use ServiceBindings;

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                BUILD_PATH.'/config/core.php' => config_path('build/core.php')
            ], 'core-config');

            $this->publishes([
                BUILD_PATH.'/database/migrations' => database_path('migrations')
            ], 'core-migrations');

            $this->publishes([
                BUILD_PATH.'/resources/views' => resource_path('views/vendor/build.core')
            ], 'core-views');

            $this->publishes([
                BUILD_PATH.'/public' => public_path('vendor/build/core'),
            ], 'core-assets');
        }

        $this->loadMigrationsFrom(BUILD_PATH.'/database/migrations');
        $this->loadViewsFrom(BUILD_PATH.'/resources/views', 'build.core');
        $this->loadTranslationsFrom(BUILD_PATH.'/resources/lang', 'build.core');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('BUILD_PATH')) {
            define('BUILD_PATH', realpath(__DIR__.'/../../'));
        }

        $this->mergeConfigFrom(BUILD_PATH.'/config/core.php', 'build.core');

        $this->registerServiceBindings();
        $this->registerProviders();
        $this->registerHelpers();
    }

    /**
     * Register Core's services in the container.
     *
     * @return void
     */
    protected function registerServiceBindings()
    {
        foreach ($this->bindings as $key => $value) {
            is_numeric($key)
                ? $this->app->singleton($value)
                : $this->app->singleton($key, $value);
        }
    }

    /**
     * Register the required Build service providers.
     *
     * @return void
     */
    protected function registerProviders()
    {
        $this->app->register(Providers\BauhausServiceProvider::class);
        $this->app->register(Providers\RequestServiceProvider::class);
        $this->app->register(Providers\RoutingServiceProvider::class);
        $this->app->register(Providers\ConsoleServiceProvider::class);
        $this->app->register(Providers\ModulesServiceProvider::class);
        $this->app->register(Providers\PolicyServiceProvider::class);
        $this->app->register(Providers\CookieServiceProvider::class);
        $this->app->register(Providers\AlertServiceProvider::class);
        $this->app->register(Providers\AssetServiceProvider::class);
        $this->app->register(Providers\RouteServiceProvider::class);
        $this->app->register(Providers\EventServiceProvider::class);
        $this->app->register(Providers\CacheServiceProvider::class);
        $this->app->register(Providers\MenuServiceProvider::class);
        $this->app->register(ImageServiceProvider::class);
    }

    /**
     * Include the helpers file.
     *
     * @return void
     */
    protected function registerHelpers()
    {
        require __DIR__.'/helpers.php';
    }
}
