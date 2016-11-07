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

use Illuminate\Contracts\Http\Kernel;

class ModuleServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * @param  string|array  $middleware
     */
    protected function addMiddleware($middleware)
    {
        $kernel = $this->app[Kernel::class];

        if (is_array($middleware)) {
            foreach ($middleware as $ware) {
                $kernel->pushMiddleware($ware);
            }
        } else {
            $kernel->pushMiddleware($middleware);
        }
    }
}