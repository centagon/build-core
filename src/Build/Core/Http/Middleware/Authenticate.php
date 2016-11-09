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

class Authenticate
{

    /**
     * @param  Request   $request
     * @param  \Closure  $next
     *
     * @return RedirectResponse|Response
     */
    public function handle($request, \Closure $next)
    {
        if (auth()->guest()) {
            // No redirects for ajax requests.
            if ($request->ajax()) {
                return response('Unauthorized', 401);
            }

            // If we cannot authenticate the current user
            // then just redirect to the login screen.
            return redirect()->guest(route('admin.sessions.create'));
        }

        // Nothing to see here, move along...
        return $next($request);
    }
}
