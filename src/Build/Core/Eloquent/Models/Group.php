<?php

namespace Build\Core\Eloquent\Models;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Group extends Model
{

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'name', 'color', 'type',
    ];

    /**
     * Scope the query by the given type.
     *
     * @param  Builder  $query
     * @param  string  $type
     */
    public function scopeByType(Builder $query, $type)
    {
        $query->where('type', $type);
    }
}