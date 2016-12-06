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
        'name', 'color', 'namespace',
    ];

    /**
     * Scope the query by the given namespace.
     *
     * @param  Builder  $query
     * @param  string  $namespace
     */
    public static function scopeBy($query, $namespace)
    {
        $query->where('namespace', $namespace);
    }
}