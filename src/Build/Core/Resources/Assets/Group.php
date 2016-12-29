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

class Group
{

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var string
     */
    protected $lastAddedType;

    /**
     * @var string
     */
    protected $lastAddedAsset;

    public function __construct()
    {
        $this->collection = collect([
            'css' => [],
            'js' => [],
        ]);
    }

    /**
     * Add one or more assets to the group.
     *
     * @param  string|array  $assets
     * @param  null|string   $name
     *
     * @return Group
     */
    public function add($assets, $name = null)
    {
        if (is_array($assets)) {
            foreach ($assets as $asset) {
                $this->add($asset, $name);
            }
        } elseif ($this->isAsset($assets)) {
            $this->addAsset($assets, $name);
        }

        return $this;
    }

    /**
     * Add a dependency to an asset.
     *
     * @param  string  $dependency
     *
     * @return Group
     */
    public function dependsOn($dependency)
    {
        $collection = $this->collection->get($this->lastAddedType);

        foreach ($collection as $path => $item) {
            if ($path === $this->lastAddedAsset) {
                $collection[$path] = [
                    'name' => $item['name'],
                    'deps' => $dependency,
                ];

                $this->collection->put($this->lastAddedType, $collection);
            }
        }

        return $this;
    }

    /**
     * Build the css link tags.
     *
     * @return string
     */
    public function css()
    {
        $output = '';

        $collection = $this->sortDependencies($this->collection->get('css'), 'css');

        foreach ($collection as $key => $value) {
            $output .= '<link rel="stylesheet" href="'.$value.'">'."\n";
        }

        return $output;
    }

    /**
     * Build the javascript script tags.
     *
     * @return string
     */
    public function js()
    {
        $output = '';

        $collection = $this->sortDependencies($this->collection->get('js'), 'js');

        foreach ($collection as $key => $value) {
            $output .= '<script type="text/javascript" src="'.$value.'"></script>'."\n";
        }

        return $output;
    }

    /**
     * Determine that the passed asset is indeed an asset.
     *
     * @param  string  $asset
     *
     * @return bool
     */
    protected function isAsset($asset)
    {
        return (bool) preg_match('/\.(css|style|js)/i', $asset);
    }

    /**
     * Determine that the passed asset is a css asset.
     *
     * @param  string  $asset
     *
     * @return bool
     */
    protected function isCss($asset)
    {
        return (bool) preg_match('/(\.css|style)/i', $asset);
    }

    /**
     * Add a file to the collection.
     *
     * @param  string       $asset
     * @param  null|string  $name
     *
     * @return Group
     */
    protected function addAsset($asset, $name = null)
    {
        $type = $this->isCss($asset) ? 'css' : 'js';

        $collection = $this->collection->get($type);

        if ( ! in_array($asset, $collection)) {
            $collection[$asset] = [
                'name' => $name,
                'deps' => [],
            ];

            $this->collection->put($type, $collection);

            $this->lastAddedType = $type;
            $this->lastAddedAsset = $asset;
        }

        return $this;
    }

    /**
     * Sort the dependency list.
     *
     * @param  array   $assets
     * @param  string  $type
     *
     * @return array
     */
    protected function sortDependencies(array $assets, $type)
    {
        $list = [];

        foreach ($assets as $key => $value) {
            if (isset($value['deps'])) {
                $list[$key] = [$this->getNamespacedAsset($value['deps'], $type)];
            } else {
                $list[$key] = null;
            }
        }

        $deps = new Dependencies($list);

        return array_filter($deps->sort());
    }

    /**
     * Get the assets from a certain namespace.
     *
     * @param  string  $namespace
     * @param  string  $type
     *
     * @return int|string
     */
    protected function getNamespacedAsset($namespace, $type)
    {
        $collection = $this->collection->get($type);

        foreach ($collection as $key => $value) {
            if ($value['name'] === $namespace) {
                return $key;
            }
        }
    }
}