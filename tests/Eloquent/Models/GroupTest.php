<?php

namespace Build\Core\Tests\Eloquent\Models;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\Color;
use Build\Core\Eloquent\Models\Group;
use Build\Core\Tests\AbstractTestCase;
use Build\Core\Eloquent\Models\Website;
use Build\Core\Eloquent\Traits\Groupable;

class GroupTest extends AbstractTestCase
{

    public function test_can_create_group()
    {
        $group = factory(Group::class)->create(['type' => Website::class]);

        $website = factory(Website::class)->create();

        $this->assertEquals($group->type, Website::class);

        $website->syncGroups([$group]);

        $this->assertCount(1, $website->groups);
        $this->assertEquals($website->groups->first()->name, $group->name);
    }

    public function test_can_get_groups_by_resource()
    {
        $group1 = factory(Group::class)->create(['type' => Website::class]);
        $group2 = factory(Group::class)->create(['type' => Website::class]);
        $otherGroup = factory(Group::class)->create(['type' => Color::class]);

        $website = factory(Website::class)->create();

        $website->syncGroups([$group1, $group2]);

        $this->assertCount(2, $website->groups);
    }

    public function test_can_remove_group_from_resource()
    {
        $group1 = factory(Group::class)->create(['type' => Website::class]);
        $group2 = factory(Group::class)->create(['type' => Website::class]);

        $website = factory(Website::class)->create();

        $website->syncGroups([$group1, $group2]);

        $this->assertCount(2, $website->groups);

        // God only knows...
        $website = Website::find($website->getKey());
        $website->syncGroups([$group1]);

        $this->assertCount(1, $website->groups);
    }
}