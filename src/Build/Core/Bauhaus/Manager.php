<?php

namespace Build\Core\Bauhaus;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Manager
{

    /**
     * Holds the current executing method.
     * @var string
     */
    protected $method;

    /**
     * Holds the current running query.
     * @var Query
     */
    protected $query;

    /**
     * @var array
     */
    protected $properties = [];

    /**
     * Holds the current Mapper instance.
     * @var Mapper
     */
    protected $mapper;

    /**
     * Holds the path to the view.
     * @var null|string
     */
    protected $view = null;

    protected $executed = false;

    public function __toString()
    {
        return $this->render();
    }

    /**
     * Get the current method.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the current method.
     *
     * @param  string  $method
     *
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Get the current query.
     *
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set the current query.
     *
     * @param  mixed  $query
     *
     * @return $this
     */
    public function setQuery($query)
    {
        if ( ! is_callable($query)) {
            $query = function () use ($query) {
                return $query;
            };
        }

        $this->query = new Query($query);

        return $this;
    }

    public function with(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * Get the Mapper instance.
     *
     * @return Mapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    /**
     * Set a new Mapper instance.
     *
     * @param  Mapper  $mapper
     *
     * @return $this
     */
    public function setMapper(Mapper $mapper)
    {
        $this->mapper = $mapper;

        return $this;
    }

    public function execute()
    {
        if ($query = $this->getQuery()) {
            $query = $query->execute();
        }

        app()->singleton('build.bauhaus.query', function () use ($query) {
            return $query;
        });

        $this
            ->setMapper($mapper = new Mapper)
            ->{$this->getMethod()}($mapper, $query, $this->properties);

        (new Builder)->build($mapper);

        return $this;
    }

    /**
     * Get the view path.
     *
     * @return string
     */
    public function getView()
    {
        if ($this->view !== null) {
            return $this->view;
        }

        return 'build.core::screens.bauhaus.default-screen';
    }

    /**
     * Render the mapper.
     *
     * @param  string|null  $view
     *
     * @return string
     */
    public function render($view = null)
    {
        if ( ! $this->executed) {
            $this->execute();
        }

        return view($view ?: $this->getView())->with([
            'manager' => $this
        ])->render();
    }
}
