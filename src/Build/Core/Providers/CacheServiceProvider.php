<?php

namespace Build\Core\Providers;

use Build\Core\Cache\FileStore;
use Illuminate\Support\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        app('cache')->extend('file', function ($app, $config) {
            $store = new FileStore($app->files, $config['path'], $app->config);

            return app('cache')->repository($store);
        });
    }
}
