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
use Build\Core\Support\Facades\Context;
use Illuminate\Contracts\Foundation\Application;

class CookieConsent
{

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param  Application  $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param  Request   $request
     * @param  \Closure  $next
     *
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        // We don't need to show the cookie consent in the
        // backend so just return the full response.
        if (Context::isBackend()) {
            return $response;
        }

        if ( ! $response instanceof Response) {
            return $response;
        }

        if ( ! $this->containsBodyTag($response)) {
            return $response;
        }

        return $this->addCookieScript($response);
    }

    /**
     * @param  Response  $response
     *
     * @return bool
     */
    protected function containsBodyTag(Response $response)
    {
        return $this->getLastClosingBodyTagPosition($response->getContent()) !== false;
    }

    /**
     * @param  Response  $response
     *
     * @return $this
     */
    protected function addCookieScript(Response $response)
    {
        $content = $response->getContent();

        $position = $this->getLastClosingBodyTagPosition($content);

        $content = ''
            .substr($content, 0, $position)
            .view('build.core::components.cookie-consent')->render()
            .substr($content, $position);

        return $response->setContent($content);
    }

    /**
     * @param  string  $content
     *
     * @return int
     */
    protected function getLastClosingBodyTagPosition($content = '')
    {
        return strripos($content, '</body>');
    }
}