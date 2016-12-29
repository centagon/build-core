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

use Build\Core\Resources\Assets\Asset;
use Build\Core\Support\Facades\Asset as AssetFacade;

class AssetServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('build.asset', function ($app) {
            return new Asset($app['view']);
        });

        $this->registerAssets();
    }

    protected function registerAssets()
    {
        AssetFacade::make('backend.css');
        AssetFacade::make('backend.js');

        AssetFacade::get('backend.css')->add(asset('vendor/build/core/css/core.css'));

        AssetFacade::get('backend.css')
            ->add(asset('css/colors.css'), 'colors.css');

        AssetFacade::get('backend.js')->add(asset('vendor/build/core/js/vendor.js'), 'vendor');
        AssetFacade::get('backend.js')->add(asset('vendor/build/core/js/core.js'), 'core');
    }
}
