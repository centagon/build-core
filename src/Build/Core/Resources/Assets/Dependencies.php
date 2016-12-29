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

class Dependencies
{

    protected $nodes = [];
    protected $roots = [];

    /**
     * @param  array  $dependencies
     */
    public function __construct(array $dependencies = [])
    {
        $this->roots = array_keys($dependencies);

        $dependencies = $this->parseDependencyList($dependencies);

        foreach ($dependencies as $pair) {
            list($asset, $dependency) = each($pair);

            if ( ! isset($this->nodes[$asset])) {
                $this->nodes[$asset] = new Node($asset);
            }

            if ( ! isset($this->nodes[$dependency])) {
                $this->nodes[$dependency] = new Node($dependency);
            }

            if ( ! in_array($dependency, $this->nodes[$asset]->children)) {
                $this->nodes[$asset]->children[] = $dependency;
            }

            if ( ! in_array($asset, $this->nodes[$dependency]->parents)) {
                $this->nodes[$dependency]->parents[] = $asset;
            }
        }
    }
    /**
     * Performs topological sorting against the passed array.
     *
     * @return array
     */
    public function sort()
    {
        $nodes = $this->nodes;
        $roots = array_values($this->getRootNodes($nodes));
        $sorted = [];

        while (count($nodes) > 0) {
            if ($roots === []) {
                return [];
            }

            $node = array_pop($roots);
            $sorted[] = $node->name;

            for ($i = count($node->children) - 1; $i >= 0; $i--) {
                $childNode = $node->children[$i];

                unset($nodes[$node->name]->children[$i]);

                $parentPosition = array_search($node->name, $nodes[$childNode]->parents);

                unset($nodes[$childNode]->parents[$parentPosition]);

                if (! count($nodes[$childNode]->parents)) {
                    array_push($roots, $nodes[$childNode]);
                }
            }

            unset($nodes[$node->name]);
        }

        $looseNodes = [];

        foreach ($this->roots as $name) {
            if ( ! in_array($name, $sorted)) {
                $looseNodes[] = $name;
            }
        }

        return array_merge($sorted, $looseNodes);
    }
    /**
     * Returns an array of node objects that do not have parents.
     *
     * @param  array  $nodes
     *
     * @return array
     */
    protected function getRootNodes(array $nodes)
    {
        $roots = [];

        foreach ($nodes as $name => $node) {
            if ( ! count($node->parents)) {
                $roots[$name] = $node;
            }
        }

        return $roots;
    }

    /**
     * Parses a list of dependencies into an array of dependency pairs.
     *
     * @param  array  $list
     *
     * @return array
     */
    protected function parseDependencyList(array $list = [])
    {
        $parsed = [];

        foreach ($list as $name => $dependencies) {
            foreach ($dependencies as $dependency) {
                array_push($parsed, [$dependency => $name]);
            }
        }

        return $parsed;
    }
}