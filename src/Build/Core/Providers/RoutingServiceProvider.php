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

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Build\Core\Http\Routing\ResourceRegistrar;

class RoutingServiceProvider extends \Illuminate\Routing\RoutingServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->overrideResourceRegistrar();

        $this->registerMiddlewares();

        $this->registerMacros();
    }

    protected function overrideResourceRegistrar()
    {
        $this->app->bind('Illuminate\Routing\ResourceRegistrar', ResourceRegistrar::class);
    }

    /**
     * Register the ore middleware.
     *
     * @return RoutingServiceProvider
     */
    protected function registerMiddlewares()
    {
        foreach (config('build.core.middleware') as $name => $middleware) {
            app('router')->aliasMiddleware($name, $middleware);
        }
    }

    protected function registerMacros()
    {
        Router::macro('admin', function ($callback, array $attributes = []) {
            $middleware = array_keys(config('build.core.middleware'));

            array_unshift($middleware, 'web');

            $attributes = array_merge([
                'prefix' => config('build.core.uri'),
                'middleware' => $middleware
            ], $attributes);

            Route::group(array_filter($attributes), $callback);
        });
    }
}
