<?php

namespace Build\Core\Eloquent\Scope;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Build\Core\Support\Facades\Discovery;

class Registry
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var Collection
     */
    protected $filters;

    /**
     * @var null
     */
    protected static $instance = null;

    /**
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $website = Discovery::backendWebsite()->getKey();
        $route = $request->route()->getName() ?: $request->route()->getUri();
        $user = auth()->user()->getKey();

        $this->key = sprintf('build.scopes.%s.%s.%s', $user, $website, $route);

        $this->filters = $request->session()->get($this->key, collect());
    }

    /**
     * Set a filter.
     *
     * @param  string  $name
     * @param  array  $value
     */
    public function set($name, $value = [])
    {
        $this->filters->put($name, $value);

        $this->persist();
    }

    /**
     * Forget an existing filter.
     *
     * @param  string  $name
     */
    public function clear($name)
    {
        $this->filters->forget($name);

        $this->persist();
    }

    /**
     * Persist the filters in the current session.
     */
    public function persist()
    {
        $this->request->session()->put($this->key, $this->filters);
    }

    /**
     * @return Collection
     */
    public function filters()
    {
        return $this->filters;
    }

    /**
     * @return Scope
     */
    public static function getInstance()
    {
        if ( ! self::$instance) {
            self::$instance = app(static::class);
        }

        return self::$instance;
    }
}