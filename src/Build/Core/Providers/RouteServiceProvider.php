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

        $this->mapProtectedAdminRoutes();
        $this->mapGuestAdminRoutes();
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
}