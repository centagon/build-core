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

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Cookie\Middleware\EncryptCookies;

class CookieServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Holds the cookie name.
     * @var string
     */
    protected $cookieName;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->cookieName = 'cookie-consent';

        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $cookies) {
            $cookies->disableFor($this->cookieName);
        });

        $this->app['view']->composer('build.core::components.cookie-consent', function (View $view) {
            $cookieExists = Cookie::has($this->cookieName);

            $view->with([
                'cookie_exists' => $cookieExists,
                'cookie_name' => $this->cookieName
            ]);
        });
    }
}