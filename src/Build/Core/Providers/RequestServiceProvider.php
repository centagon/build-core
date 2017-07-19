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

use Build\Core\Support\Context;
use Build\Core\Http\Routing\Discovery;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class RequestServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('build.core.discovery', Discovery::class);
        $this->app->singleton('build.context', Context::class);

        $this->registerMacros();
    }

    /**
     * Register the request macros.
     */
    protected function registerMacros()
    {
        Request::macro('isFrontend', function (): bool {
            return app('build.context')->isFrontend();
        });

        Request::macro('isBackend', function (): bool {
            return app('build.context')->isBackend();
        });

        Request::macro('website', function () {
            return app('build.core.discovery')->website();
        });

        Request::macro('backendWebsite', function () {
            return app('build.core.discovery')->backendWebsite();
        });
    }
}
