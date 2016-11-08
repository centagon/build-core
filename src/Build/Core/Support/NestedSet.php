<?php

namespace Build\Core\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class NestedSet
{

    /**
     * Parent instance.
     * @var NestedSet
     */
    protected $parent;

    /**
     * NestedSet children.
     * @var array
     */
    protected $children = [];

    /**
     * Public class constructor.
     *
     * @param  array  $children
     */
    public function __construct(array $children = [])
    {
        if (! empty($children)) {
            $this->setChildren($children);
        }
    }

    /**
     * Add a child.
     *
     * @param  NestedSet  $child
     *
     * @return $this
     */
    public function addChild(NestedSet $child)
    {
        $child->setParent($this);
        $this->children[] = $child;

        return $this;
    }

    /**
     * Add multiple children at once.
     *
     * @param  array  $children
     *
     * @return $this
     */
    public function addChildren(array $children)
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * Remove a node from the children.
     *
     * @param  NestedSet  $child
     *
     * @return $this
     */
    public function removeChild(NestedSet $child)
    {
        foreach ($this->children as $key => $instance) {
            if ($child == $instance) {
                unset($this->children[$key]);
            }
        }

        $this->children = array_values($this->children);
        $child->setParent(null);

        return $this;
    }

    /**
     * Remove all children.
     *
     * @return $this
     */
    public function removeAllChildren()
    {
        $this->setChildren([]);

        return $this;
    }

    /**
     * Return the array of children.
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Replace the children set with the given one.
     *
     * @param  array  $children
     *
     * @return $this
     */
    public function setChildren(array $children)
    {
        $this->removeParentFromChildren();
        $this->children = [];

        foreach ($children as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * Check the node for children.
     *
     * @return bool
     */
    public function hasChildren()
    {
        return count($this->getChildren()) > 0;
    }

    /**
     * Set the parent node.
     *
     * @param  NestedSet  $parent
     *
     * @return $this
     */
    public function setParent(NestedSet $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get the parent node.
     *
     * @return NestedSet
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Return all ancestors of the node
     * excluding the current node.
     *
     * @return array
     */
    public function getAncestors()
    {
        $parents = [];
        $node = $this;

        while ($parent = $node->getParent()) {
            array_unshift($parents, $parent);

            $node = $parent;
        }

        return $parents;
    }

    /**
     * Return all ancestors of the node
     * as well as the node itself.
     *
     * @return array
     */
    public function getAncestorsAndSelf($columns = [])
    {
        return array_merge($this->getAncestors(), [$this]);
    }

    /**
     * Get all neighboring nodes, excluding
     * the current node.
     *
     * @return array
     */
    public function getNeighbors()
    {
        if (! $this->getParent()) {
            return [];
        }

        $neighbors = $this->getNeighborsAndSelf();
        $current = $this;

        return array_values(array_filter($neighbors, function ($item) use ($current) {
            return $item !== $current;
        }));
    }

    /**
     * Get all neighboring nodes, including
     * the current node.
     *
     * @return array
     */
    public function getNeighborsAndSelf()
    {
        if (! $this->getParent()) {
            return [$this];
        }

        return $this->getParent()->getChildren();
    }

    /**
     * Return true if the node has no children,
     * False otherwise.
     *
     * @return bool
     */
    public function isLeaf()
    {
        return count($this->children) === 0;
    }

    /**
     * Return true if the node is the root,
     * false otherwise.
     *
     * @return bool
     */
    public function isRoot()
    {
        return $this->getParent() === null;
    }

    /**
     * Return true if the node is a child,
     * false otherwise.
     *
     * @return bool
     */
    public function isChild()
    {
        return $this->getParent() !== null;
    }

    /**
     * Get the root node.
     *
     * @return NestedSet
     */
    public function getRoot()
    {
        $node = $this;

        while ($parent = $node->getParent()) {
            $node = $parent;
        }

        return $node;
    }

    /**
     * Return the distance from the current
     * node to the root.
     *
     * @return int
     */
    public function getDepth()
    {
        if ($this->isRoot()) {
            return 0;
        }

        return $this->getParent()->getDepth() + 1;
    }

    /**
     * Return the height of the tree
     * whose root is this node.
     *
     * @return int|mixed
     */
    public function getHeight()
    {
        if ($this->isLeaf()) {
            return 0;
        }

        $height = [];

        foreach ($this->getChildren() as $child) {
            $height[] = $child->getHeight();
        }

        return max($height) + 1;
    }

    protected function removeParentFromChildren()
    {
        foreach ($this->getChildren() as $child) {
            $child->setParent(null);
        }
    }
}
