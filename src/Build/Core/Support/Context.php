<?php

namespace Build\Core\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class Context
{

    const FRONTEND = 'frontend';
    const BACKEND = 'backend';

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string|null
     */
    protected $context = null;

    /**
     * @param  Application  $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get the current request context.
     *
     * @param  Request|null  $request
     *
     * @return string
     */
    public function get(Request $request = null)
    {
        // Did someone, somewhere override the context somehow?
        // Don't worry, there may be a reason for this so
        // just do what we're asked for.
        if ($this->context !== null) {
            return $this->context;
        }

        if ($request === null) {
            $request = $this->app->request;
        }

        return $request->is(config('build.core.uri') . '*')
            ? static::BACKEND
            : static::FRONTEND;
    }

    /**
     * Override the current context.
     *
     * @param  string  $context
     */
    public function override($context)
    {
        $this->context = $context;
    }

    /**
     * Determine that the current request is on the frontend context.
     *
     * @return bool
     */
    public function isFrontend()
    {
        return $this->get() === static::FRONTEND;
    }

    /**
     * Determine that the current request is on the backend context.
     *
     * @return bool
     */
    public function isBackend()
    {
        return ! $this->isFrontend();
    }
}
