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

use Build\Core\Support\Alert\MessageBag;

class AlertServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('build.alert', MessageBag::class);
    }
}