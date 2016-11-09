<?php

namespace Build\Core\Http\Middleware;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;
use Build\Core\Eloquent\Scope\Registry;

class ScopeState
{

    /**
     * @param  Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {
        if (($filter = $request->get('clearfilter'))) {
            Registry::getInstance()->clear($filter);
        }

        if (($filter = $request->get('setfilter'))) {
            if (strpos($filter, ':') > 1) {
                $parts = explode(':', $filter, 2);

                $filter = $parts[0];
                $value = [$parts[1]];
            } else {
                $value = $request->get('filtervalue');
            }

            Registry::getInstance()->set($filter, $value);
        }

        return $next($request);
    }
}
