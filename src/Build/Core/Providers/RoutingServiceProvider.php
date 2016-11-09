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

use Build\Core\Http\Routing\Router;

class RoutingServiceProvider extends \Illuminate\Routing\RoutingServiceProvider
{

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('router', Router::class);

        $this->registerMiddlewares(config('build.core.middleware'));
    }

    protected function registerMiddlewares(array $middlewares)
    {
        $router = $this->app['router'];

        foreach ($middlewares as $name => $class) {
            $router->middleware($name, $class);
        }
    }
}
