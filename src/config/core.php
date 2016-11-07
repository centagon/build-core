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

    /*
     |--------------------------------------------------------------------------
     | Backend URI
     |--------------------------------------------------------------------------
     |
     | This value determines where the "backend section" of build is located.
     */

    'uri' => env('BUILD_URI', 'admin'),

    /*
     |--------------------------------------------------------------------------
     | Backend Middleware
     |--------------------------------------------------------------------------
     |
     | These are the middleware that get executed on backend routes.
     */

    'middleware' => [

        'installed' => Build\Core\Http\Middleware\Installed::class,
        'scope-state' => Build\Core\Http\Middleware\ScopeState::class,
        'springboard' => Build\Core\Http\Middleware\Springboard::class,
        'authenticate' => Build\Core\Http\Middleware\Authenticate::class,

    ],

    /*
     |--------------------------------------------------------------------------
     | Path to Modules.
     |--------------------------------------------------------------------------
     |
     | Define the path where you'd like to store your modules. Note that if you
     | choose a path that's outside of your public directory, you will need to
     | copy your module assets (CSS, images, etc.) to your public directory.
     */

    'modules-path' => env('BUILD_MODULES_PATH', app_path('Modules')),

    /*
     |--------------------------------------------------------------------------
     | Modules Default State.
     |--------------------------------------------------------------------------
     |
     | When a previously unknown module is added, if it doesn't have an 'enabled'
     | state set then this is the value which it will default to. If this is
     | not provided then the module will default to being 'enabled.
     */

    'modules-enabled' => env('BUILD_MODULES_ENABLED', true),

    /*
     |--------------------------------------------------------------------------
     | Module Base Namespace.
     |--------------------------------------------------------------------------
     |
     | Define the base namespace for your modules. Be sure to update this
     | value if you move your modules directory to a new path. This
     | is primarily used by the Artisan module:make command.
     */

    'modules-namespace' => env('BUILD_MODULES_NAMESPACE', 'App\\Modules\\'),
];