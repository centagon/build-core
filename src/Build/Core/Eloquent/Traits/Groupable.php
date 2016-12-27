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
use Illuminate\Database\Eloquent\Builder;

trait Groupable
{

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function groups()
    {
        return $this->morphToMany(static::getGroupClassName(), 'groupable');
    }

    /**
     * Sync the old and new groups.
     *
     * @param  array|Collection  $groups
     *
     * @return $this
     */
    public function syncGroups($groups)
    {
        if ( $groups instanceof Collection) {
            $groups = $groups->pluck('id')->toArray();
        }

        $this->groups()->sync($groups);

        return $this;
    }

    /**
     * Restrict the query on a certain set of groups.
     *
     * @param  Builder  $query
     * @param  null|string|array  $type
     */
    public function scopeAllByGroup(Builder $query, $type = null)
    {
        if ($type === null) {
            $type = collect(get_class($this));
        }

        if ( ! $type instanceof Collection) {
            $type = collect($type);
        }

        $query->whereHas('groups', function ($q) use ($type) {
            $q->whereIn('type', $type->toArray());
        });
    }

    public static function getGroupClassName()
    {
        return Group::class;
    }
}