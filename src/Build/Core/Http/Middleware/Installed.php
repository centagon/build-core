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
use Illuminate\Http\Response;

class Installed
{

    /**
     * @param  Request   $request
     * @param  \Closure  $next
     *
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
}
