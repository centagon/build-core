<?php

namespace Build\Core\Bauhaus\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Container
{

    /**
     * Holds a collection of registered widgets.
     * @var \Illuminate\Support\Collection
     */
    protected $widgets;

    public function __construct()
    {
        $this->widgets = collect();
    }

    /**
     * Register a single or an array of widgets.
     *
     * @param  string|array  $alias
     * @param  string|null   $namespace
     *
     * @return $this
     */
    public function register($alias, $namespace = null)
    {
        if (is_array($alias)) {
            foreach ($alias as $key => $namespace) {
                $this->register($key, $namespace);
            }

            return $this;
        }

        $this->widgets->put($alias, $namespace);

        return $this;
    }

    /**
     * Get a widget namespace by alias.
     *
     * @param  string  $alias
     *
     * @return string
     */
    public function get($alias)
    {
        return $this->widgets->get($alias);
    }
}
