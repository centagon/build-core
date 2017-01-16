<?php

namespace Build\Core\Resources\Assets;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\View\Factory;
use Illuminate\Support\Collection;

class Asset
{

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @param  Factory  $factory
     */
    public function __construct(Factory $factory)
    {
        $this->collection = collect();

        $factory->share('asset', $this);
    }

    public function make($namespace, $callback = null)
    {
        $group = new Group;

        if (is_callable($callback)) {
            $callback($group);
        }

        $this->collection->put($namespace, $group);

        return $group;
    }

    public function get($namespace, $default = null)
    {
        if ( ! $this->collection->has($namespace)) {
            $this->make($namespace);
        }

        return $this->collection->get($namespace, $default);
    }
}