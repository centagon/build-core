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

class ResourceRegistrar extends \Illuminate\Routing\ResourceRegistrar
{
    /**
     * Get the name for a given resource.
     *
     * @param  string  $resource
     * @param  string  $method
     * @param  array   $options
     * @return string
     */
    protected function getResourceRouteName($resource, $method, $options): string
    {
        return sprintf(
            '%s.%s',
            $this->router->getLastGroupPrefix(),
            parent::getResourceRouteName($resource, $method, $options)
        );
    }

    /**
     * Get the name for a grouped resource.
     *
     * @param  string  $prefix
     * @param  string  $resource
     * @param  string  $method
     *
     * @return string
     */
    protected function getGroupResourceName($prefix, $resource, $method)
    {
        $group = ltrim(str_replace('/', '.', $this->router->getLastGroupPrefix()), '.');

        $parts = explode('.', $group);
        $first = array_shift($parts);

        if ( ! empty($parts)) {
            $group = $first;

            $resource = implode('.', $parts) . '.' . $resource;
        }

        if ( ! empty($group) && $group == config('build.core.uri')) {
            return trim("{$prefix}admin.{$resource}.{$method}", '.');
        }

        return trim("{$prefix}{$resource}.{$method}", '.');
    }
}
