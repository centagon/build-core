<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    'uri' => 'admin',

    'title' => 'Centagon Build',

    'middleware' => [
        'installed' => Build\Core\Http\Middleware\Installed::class,
        'scope-state' => Build\Core\Http\Middleware\ScopeState::class,
        'authenticate' => Build\Core\Http\Middleware\Authenticate::class,
    ],
];