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

class Login extends Model
{

    const TYPE_ATTEMPT = 'attempt';
    const TYPE_SUCCESS = 'success';

    /**
     * Override the table name.
     * @var string
     */
    protected $table = 'login_attempts';

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}