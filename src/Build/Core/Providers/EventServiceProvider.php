<?php

namespace Build\Core\Providers;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Auth\Events\Login;
use Build\Core\Listeners\LoginAttempt;
use Illuminate\Auth\Events\Attempting;

class EventServiceProvider extends \Illuminate\Foundation\Support\Providers\EventServiceProvider
{

    /**
     * The event listener mappings for the application.
     * @var array
     */
    protected $listen = [
        Attempting::class => [
            LoginAttempt::class
        ],

        Login::class => [
            LoginAttempt::class
        ]
    ];
}
