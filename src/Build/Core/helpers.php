<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (! function_exists('alert')) {
    /**
     * @return Build\Core\Support\Alert\MessageBag
     */
    function alert()
    {
        return app('build.alert');
    }
}

if (! function_exists('build_route_string')) {
    /**
     * Generate a named route string.
     *
     * @param  string  $name
     *
     * @return string
     * @deprecated 2.0
     */
    function build_route_string($name)
    {
        return 'admin.' . $name;
    }
}

if (! function_exists('build_route')) {
    /**
     * Generate a URL to a named route.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     * @param  Illuminate\Routing\Route  $route
     *
     * @return string
     * @deprecated 2.0
     */
    function build_route($name, $parameters = [], $absolute = true, $route = null)
    {
        return route(build_route_string($name), $parameters, $absolute, $route);
    }
}

if (! function_exists('entity')) {
    /**
     * @param  string  $entity
     * @param  null|string  $method
     *
     * @return \Illuminate\Http\Response
     */
    function entity($entity, $method = null)
    {
        return (new Build\Core\Bauhaus\Factory)->make($entity, $method);
    }
}

if (! function_exists('get_traits')) {
    /**
     * Get all traits defined on the given class.
     *
     * @param  string  $class
     *
     * @return Generator
     */
    function get_traits($class)
    {
        if (! is_string($class)) {
            $class = get_class($class);
        }

        foreach (class_uses_recursive($class) as $trait) {
            yield class_basename($trait);
        }
    }
}

if (! function_exists('has_trait')) {
    /**
     * Determine that the given trait exists on the given instance.
     *
     * @param  mixed   $instance
     * @param  string  $whichTrait
     *
     * @return bool
     */
    function has_trait($instance, $whichTrait)
    {
        $baseTrait = class_basename($whichTrait);

        foreach (get_traits($instance) as $trait) {
            if (($trait == $whichTrait) || ($trait == $baseTrait)) {
                return true;
            }
        }

        return false;
    }
}

if (! function_exists('try_method')) {
    /**
     * Test the existence of a certain method and try calling it when it does exist.
     *
     * @param  mixed   $instance
     * @param  string  $method
     * @param  array   $parameters
     */
    function try_method($instance, $method, array $parameters = [])
    {
        if (method_exists($instance, $method)) {
            call_user_func_array([$instance, $method], $parameters);
        }
    }
}