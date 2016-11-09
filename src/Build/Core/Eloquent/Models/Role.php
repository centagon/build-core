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

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    // Available user roles.
    const SUPER_ADMINISTRATORS  = 'superadmin';
    const ADMINISTRATORS = 'admin';
    const EDITORS = 'editor';
    const AUTHORS = 'author';
    const CONTRIBUTORS = 'contributor';

    /**
     * Disable automatic timestamping.
     * @var bool
     */
    public $timestamps = false;

    /**
     * Disable auto-increment.
     * @var bool
     */
    public $incrementing = false;

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
