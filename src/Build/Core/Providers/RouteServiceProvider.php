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

use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends \Illuminate\Foundation\Support\Providers\RouteServiceProvider
{

    protected $namespace = 'Build\Core\Http\Controllers';
    protected $path;

    public function map()
    {
        $this->path = __DIR__ . '/../../../routes';

        if ( ! $this->app->routesAreCached()) {
            $this->mapProtectedAdminRoutes();
            $this->mapGuestAdminRoutes();
            $this->mapAsyncAdminRoutes();
            $this->mapFrontendRoutes();
        }
    }

    protected function mapProtectedAdminRoutes()
    {
        Route::admin(function () {
            require $this->path . '/guarded.php';
        }, ['namespace' => $this->namespace]);
    }

    protected function mapGuestAdminRoutes()
    {
        Route::group([
            'middleware' => ['web'],
            'namespace' => $this->namespace,
            'prefix' => config('build.core.uri'),
        ], function () {
            require $this->path . '/guest.php';
        });
    }

    protected function mapAsyncAdminRoutes()
    {
        Route::group([
            'middleware' => ['web'],
            'namespace' => $this->namespace . '\\Async',
            'prefix' => config('build.core.uri') . '/async',
        ], function () {
            require $this->path . '/async.php';
        }, ['namespace' => $this->namespace]);
    }

    protected function mapFrontendRoutes()
    {
        Route::group([
            'middleware' => ['web'],
            'namespace' => $this->namespace
        ], function () {
            require $this->path . '/frontend.php';
        }, ['namespace' => $this->namespace]);
    }
}
