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

class EntryPolicy extends Policy
{

    /**
     * Override the policy name.
     * @var string
     */
    protected $policyName = 'languageentry';

    /**
     * Define the policy capabilities.
     * @var array
     */
    protected $capabilities = [
        'index' => ['admin', 'editor'],
        'create' => ['admin', 'editor'],
        'edit' => ['admin', 'editor'],
        'delete' => ['admin', 'editor']
    ];
}
