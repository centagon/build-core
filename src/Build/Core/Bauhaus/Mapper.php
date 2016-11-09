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

use Build\Core\Support\NestedSet;

class Mapper extends NestedSet
{

    // query types.
    const QUERY_TYPE_NONE = 'none';
    const QUERY_TYPE_SINGLE = 'single';
    const QUERY_TYPE_MULTIPLE = 'multiple';

    /**
     * Holds the query type.
     * @var string
     */
    protected $queryType = self::QUERY_TYPE_SINGLE;

    /**
     * Holds the mapper properties.
     * @var array
     */
    protected $properties = [];

    /**
     * Whether or not the query is paginated.
     * @var bool
     */
    protected $isPaginated = false;

    /**
     * Holds the possible set of rows from the Builder.
     * @var mixed
     */
    protected $rows;

    /**
     * Holds the current row.
     * @var mixed
     */
    protected $row;

    /**
     * Holds the path to the view.
     * @var null|string
     */
    protected $view = null;

    /**
     * Magic method getter/setter.
     *
     * @param  string  $method
     * @param  array   $arguments
     *
     * @return Mapper
     */
    public function __call($method, array $arguments = [])
    {
        if (isset($arguments[0])) {
            return $this->set($method, $arguments[0]);
        }

        return $this->get($method);
    }

    /**
     * Magic property setter.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return $this
     */
    public function __set($key, $value)
    {
        $this->set($key, $value);

        return $this;
    }

    /**
     * Magic property getter.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Magic property `checker`.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return $this->has($key);
    }

    /**
     * Get a property on the implementing object.
     *
     * @param  string  $property
     * @param  mixed   $default
     *
     * @return mixed
     */
    public function get($property, $default = null)
    {
        if (! $this->has($property)) {
            return $default;
        }

        return $this->properties[$property];
    }

    /**
     * Get all the properties.
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Check if the object has a certain property.
     *
     * @param  string  $property
     *
     * @return bool
     */
    public function has($property)
    {
        return isset($this->properties[$property]);
    }

    /**
     * Set a property on the implementing object.
     *
     * @param  string  $property
     * @param  mixed   $value
     *
     * @return $this
     */
    public function set($property, $value = null)
    {
        if (is_array($property)) {
            foreach ($property as $key => $value) {
                $this->set($key, $value);
            }

            return $this;
        }

        if (is_callable($value)) {
            switch ($this->getParent()->getQueryType()) {
                case self::QUERY_TYPE_SINGLE:
                    $this->properties[$property] = $value;
                    break;

                case self::QUERY_TYPE_MULTIPLE:
                    foreach (app('build.bauhaus.query') as $row) {
                        $this->setRow($row);
                        $this->properties[$property] = $value;
                    }
                    break;
            }

            return $this;
        }

        $this->properties[$property] = $value;

        return $this;
    }

    /**
     * Add a new child.
     *
     * @param  string         $instance
     * @param  \Closure|null  $callback
     *
     * @return $this
     * @throws \Exception
     */
    public function add($instance, $callback = null)
    {
        if (is_string($instance)) {
            $class = $instance;

            if (! class_exists($instance)) {
                $instance = app('build.bauhaus.container')->get($instance);
            }

            // Try again.
            if (! class_exists($instance)) {
                throw new \Exception("Mapper cannot create an instance of `{$class}`. Make sure it exists in the config");
            }

            $instance = new $instance;
        }

        $instance->setParent($this);

        $this->addChild($instance);

        if (is_array($callback)) {
            foreach ($callback as $key => $value) {
                $instance->set($key, $value);
            }
        }

        if (is_callable($callback)) {
            $callback($instance);
        }

        return $this;
    }

    /**
     * Get the current query type.
     *
     * @return string
     */
    public function getQueryType()
    {
        return $this->queryType;
    }

    /**
     * Set the current query type.
     *
     * @param  string  $queryType
     *
     * @return $this
     */
    public function setQueryType($queryType)
    {
        $this->queryType = $queryType;

        return $this;
    }

    /**
     * Set the current row for this instance.
     *
     * @param  mixed  $row
     *
     * @return $this
     */
    public function setRow($row)
    {
        $this->row = $row;

        return $this;
    }

    /**
     * Get the current row for this instance.
     *
     * @return mixed
     */
    public function getRow()
    {
        return $this->row;
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

        $view = strtolower(class_basename($this));

        return sprintf('build.core::components.widgets.%s', $view);
    }

    /**
     * Get the rendered view.
     *
     * @return string
     */
    public function render()
    {
        return view($this->getView())->with([
            'node' => $this
        ])->render();
    }
}
