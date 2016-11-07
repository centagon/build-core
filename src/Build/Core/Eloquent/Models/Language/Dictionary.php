<?php

namespace Build\Core\Eloquent\Models\Language;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{

    /**
     * Override the table name.
     * @var string
     */
    protected $table = 'language_dictionaries';

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'label', 'description'
    ];


}