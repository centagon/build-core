<?php

namespace Build\Core\Tests\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Support\NestedSet;
use Build\Core\Tests\AbstractTestCase;

class NestedSetTest extends AbstractTestCase
{

    public function test_empty_root()
    {
        $root = new NestedSet;

        $this->assertEmpty($root->getParent());
        $this->assertEmpty($root->getChildren());
        $this->assertFalse($root->hasChildren());
    }

    public function test_can_add_child()
    {
        $root = new NestedSet;
        $root->addChild($child = new NestedSet);

        $this->assertEmpty($root->getParent());
        $this->assertNotEmpty($root->getChildren());
        $this->assertCount(1, $root->getChildren());

        $this->assertEquals($child->getParent(), $root);
        $this->assertTrue($root->hasChildren());
    }

    public function test_can_add_multiple_children()
    {
        $amount = rand(1, 25);

        $root = new NestedSet;

        for ($i = 0; $i < $amount; $i++) {
            $root->addChild(new NestedSet);
        }

        $this->assertEmpty($root->getParent());
        $this->assertNotEmpty($root->getChildren());
        $this->assertCount($amount, $root->getChildren());
        $this->assertTrue($root->hasChildren());
    }

    public function test_can_remove_a_child()
    {
        $root = new NestedSet;
        $root->addChild($child = new NestedSet);

        $this->assertNotNull($child->getParent());
        $this->assertNotEmpty($root->getChildren());
        $this->assertTrue($root->hasChildren());

        $root->removeChild($child);

        $this->assertNull($child->getParent());
        $this->assertEmpty($root->getChildren());
        $this->assertFalse($root->hasChildren());
    }

    public function test_remove_all_children()
    {
        $amount = rand(1, 25);

        $root = new NestedSet;

        for ($i = 0; $i < $amount; $i++) {
            $root->addChild(new NestedSet);
        }

        $this->assertEmpty($root->getParent());
        $this->assertNotEmpty($root->getChildren());
        $this->assertCount($amount, $root->getChildren());
        $this->assertTrue($root->hasChildren());

        $root->removeAllChildren();

        $this->assertEmpty($root->getChildren());
        $this->assertFalse($root->hasChildren());
    }

    public function test_can_override_children()
    {
        $amount = rand(1, 25);

        $root = new NestedSet;

        for ($i = 0; $i < $amount; $i++) {
            $root->addChild(new NestedSet);
        }

        $this->assertEmpty($root->getParent());
        $this->assertNotEmpty($root->getChildren());
        $this->assertCount($amount, $root->getChildren());
        $this->assertTrue($root->hasChildren());

        $root->setChildren([
            new NestedSet,
            new NestedSet
        ]);

        $this->assertEmpty($root->getParent());
        $this->assertNotEmpty($root->getChildren());
        $this->assertCount(2, $root->getChildren());
        $this->assertTrue($root->hasChildren());
    }

    public function test_can_set_parent()
    {
        $root = new NestedSet;
        $child = new NestedSet;

        $child->setParent($root);

        $this->assertEquals($root, $child->getParent());
        $this->assertEmpty($root->getChildren());
    }

    public function test_can_get_ancestors()
    {
        $child = new NestedSet;
        $root = new NestedSet([
            $child
        ]);

        $this->assertCount(0, $root->getAncestors());
        $this->assertCount(1, $child->getAncestors());

        $this->assertCount(1, $root->getAncestorsAndSelf());
        $this->assertCount(2, $child->getAncestorsAndSelf());
    }

    public function test_can_get_neighbors()
    {
        $root = new NestedSet;

        $child1 = new NestedSet;
        $child2 = new NestedSet;
        $child3 = new NestedSet;

        $root->addChildren([$child1, $child2, $child3]);

        $this->assertCount(0, $root->getNeighbors());
        $this->assertCount(1, $root->getNeighborsAndSelf());

        $this->assertCount(2, $child1->getNeighbors());
        $this->assertCount(2, $child2->getNeighbors());
        $this->assertCount(2, $child3->getNeighbors());

        $this->assertCount(3, $child1->getNeighborsAndSelf());
        $this->assertCount(3, $child2->getNeighborsAndSelf());
        $this->assertCount(3, $child3->getNeighborsAndSelf());
    }
}