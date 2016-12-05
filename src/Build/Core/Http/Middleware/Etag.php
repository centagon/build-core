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
use Illuminate\Http\RedirectResponse;

class Etag
{

    /**
     * @param  Request   $request
     * @param  \Closure  $next
     *
     * @return Response|RedirectResponse
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        if ($request->isMethod('GET')) {
            $etag = md5($response->getContent());

            $requestTag = str_replace('"', '', $request->getETags());

            if ($requestTag && $requestTag[0] == $etag) {
                $response->setNotModified();
            }

            $response->setEtag($etag);
            $response->setMaxAge(600);
        }

        return $response;
    }
}