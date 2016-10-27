<?php

namespace Build\Core\Http;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

trait Kernel
{

    protected $router;

    /**
     * Get the route dispatcher callback.
     *
     * @return callable
     */
    protected function dispatchToRouter()
    {
        $this->router = app('router');

        $this->registerMiddlewareGroups();
        $this->registerMiddleware();

        return parent::dispatchToRouter();
    }

    /**
     * Register middleware groups on the router.
     */
    protected function registerMiddlewareGroups()
    {
        foreach ($this->middlewareGroups as $key => $middleware) {
            $this->router->middlewareGroup($key, $middleware);
        }
    }

    /**
     * Register the middlewares on the router.
     */
    protected function registerMiddleware()
    {
        foreach ($this->routeMiddleware as $key => $middleware) {
            $this->router->middleware($key, $middleware);
        }
    }
}
