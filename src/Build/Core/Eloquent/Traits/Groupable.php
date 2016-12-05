<?php

namespace Build\Core\Eloquent\Traits;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\Collection;
use Build\Core\Eloquent\Models\Group;

trait Groupable
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function groups()
    {
        return $this->morphToMany(Group::class, 'groupable');
    }

    /**
     * Sync the old and new groups.
     *
     * @param  array|Collection  $groups
     *
     * @return mixed
     */
    public function syncGroups($groups)
    {
        if ($groups instanceof Collection) {
            $groups = $groups->pluck('id')->all();
        }

        return $this->groups()->sync($groups);
    }
}