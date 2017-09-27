<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Ramsey\Uuid\Uuid;
use Build\Core\Support\System;
use Build\Core\Support\AssetContainer;
use Build\Content\Support\Facades\Discovery;
use Build\Core\Eloquent\Models\Language\Entry;

if (! function_exists('asset_get')) {
    /**
     * Get the cached asset. If the asset isn't cached we try to
     * safely fall back to get the asset from the eloquent model.
     *
     * @param  int $id
     * @return \Build\Core\Eloquent\Models\Asset|null
     */
    function asset_get($id)
    {
        return AssetContainer::get($id);
    }
}

if ( ! function_exists('uuid')) {
    /**
     * Generate a uuid based on 
     * @return string
     */
    function uuid() {
        if (System::is64Bits()) {
            return Uuid::uuid1();
        }
        return Uuid::uuid4();
    }
}

if ( ! function_exists('alert')) {
    /**
     * @return Build\Core\Support\Alert\MessageBag
     */
    function alert()
    {
        return app('build.alert');
    }
}

if ( ! function_exists('build_route_string')) {
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

if ( ! function_exists('build_route')) {
    /**
     * Generate a URL to a named route.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $absolute
     *
     * @return string
     * @deprecated 2.0
     */
    function build_route($name, $parameters = [], $absolute = true)
    {
        return route(build_route_string($name), $parameters, $absolute);
    }
}

if (! function_exists('cc')) {
    /**
     * Contextual tagged file caching.
     *
     * @param  array|mixed  $names
     * @return Build\Core\Cache\TaggedCache
     */
    function cc($names)
    {
        $names = is_array($names) ? $names : func_get_args();

        array_unshift($names, request()->context());

        return cache()->tags($names);
    }
}

if ( ! function_exists('entity')) {
    /**
     * @param  string  $entity
     * @param  null|string  $method
     *
     * @return \Build\Core\Bauhaus\Manager
     */
    function entity($entity, $method = null)
    {
        return (new Build\Core\Bauhaus\Factory)->make($entity, $method);
    }
}

if ( ! function_exists('get_traits')) {
    /**
     * Get all traits defined on the given class.
     *
     * @param  string  $class
     *
     * @return Generator
     */
    function get_traits($class)
    {
        if ( ! is_string($class)) {
            $class = get_class($class);
        }

        foreach (class_uses_recursive($class) as $trait) {
            yield class_basename($trait);
        }
    }
}

if ( ! function_exists('has_trait')) {
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

if ( ! function_exists('module_path')) {
    /**
     *
     */
    function module_path($slug)
    {
        $path = config('build.core.modules-path');

        $module = \Build\Core\Support\Facades\Modules::where('slug', $slug);

        return $path . '/' . $module['basename'];
    }
}

if ( ! function_exists('try_method')) {
    /**
     * Test the existence of a certain method and try calling it when it does exist.
     *
     * @param  \Build\Core\Eloquent\Model  $instance
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

if (! function_exists('lang')) {

    function lang($label, $locale = null)
    {
        if ($locale === null && Discovery::website()) {
            $locale = Discovery::website()->language->locale;
        }

        $entry = (new Entry)->translate($label, $locale);

        if ($entry == $label) {
            return null;
        }

        return $entry;
    }
}

if (!function_exists('form_select')) {

    function form_select($name, $options = [], $default = '', $attr = [])
    {
        $attributes = [];
        
        foreach ($attr as $key => $value) {
            $attributes[] = "{$key}=\"$value\"";
        }
        
        $attributes = implode(' ', $attributes);
        
        $multiple = array_get($attr, 'multiple', false);
        
        if ($multiple) {
            
            if (empty($default)) {
                $default = [];
            }
            
        }
        
        $old = old($name, $default);
        
        return (string) view('build.core::components.form.select', compact('name', 'options', 'default', 'attributes', 'multiple','old'));
    }

}