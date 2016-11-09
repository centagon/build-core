<?php

namespace Build\Core\Http\Routing;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Router extends \Illuminate\Routing\Router
{

    public function admin(callable $callback, array $attributes = [])
    {
        $prefix = config('build.core.uri');

        $middleware = array_keys(config('build.core.middleware'));

        array_unshift($middleware, 'web');

        // Hacky way to fix Laravel-Debugbar middleware errors.
        $middleware = array_combine($middleware, $middleware);

        $attributes = array_merge($attributes, [
            'prefix' => $prefix,
            'middleware' => $middleware
        ]);

        $this->group(array_filter($attributes), $callback);
    }

    /**
     * Route a resource to a controller.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array   $options
     */
    public function resource($name, $controller, array $options = [])
    {
        $registrar = new ResourceRegistrar($this);

        $registrar->register($name, $controller, $options);
    }
}
