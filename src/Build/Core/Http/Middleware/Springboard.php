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

class Springboard
{

    /**
     * @param  Request   $request
     * @param  \Closure  $next
     *
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        if (auth()->guest()) {
            return $next($request);
        }

        if (request()->segment(2) !== 'springboard') {
            $website = session('backend.website_id');

            if ( ! $website) {
                return redirect()->intended(route('admin.springboard.index'));
            }
        }

        return $next($request);
    }
}
