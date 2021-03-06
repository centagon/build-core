<?php

namespace Build\Core\Policies\Language;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Policies\Policy;

class DictionaryPolicy extends Policy
{

    /**
     * Define the policy capabilities.
     * @var array
     */
    protected $capabilities = [
        'index' => ['admin', 'editor'],
        'create' => [],
        'edit' => ['admin'],
        'delete' => [],
        'clearcache' => ['admin', 'editor'],
    ];
}
