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

class Filter
{

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @param  string  $method
     * @param  string  $label
     * @param  string|null  $icon
     */
    public function __construct($method, $label, $icon = null)
    {
        $this->setMethod($method);
        $this->setLabel($label);
        $this->setIcon($icon);
    }

    /**
     * Get the filter label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the filter label.
     *
     * @param  string  $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the filter method.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Set the filter method.
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
     * Determine if this filter has an icon.
     *
     * @return bool
     */
    public function hasIcon()
    {
        return $this->icon !== null;
    }

    /**
     * Get the filter icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the filter icon.
     *
     * @param  string  $icon
     *
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Determine that this filter has options.
     *
     * @return bool
     */
    public function hasOptions()
    {
        return count($this->getOptions()) > 0;
    }

    /**
     * Get the filter options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the filter options.
     *
     * @param  array  $options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Determine that this filter is active.
     *
     * @param  string|null  $key
     *
     * @return bool
     */
    public function isActive($key = null)
    {
        $method = $this->getMethod();

        if ($values = Registry::getInstance()->get($method, [])) {
            return $key
                ? in_array($key, $values)
                : ! empty($values);
        }

        return false;
    }
}