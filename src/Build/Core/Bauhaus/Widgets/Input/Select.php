<?php

namespace Build\Core\Bauhaus\Widgets\Input;

/**
 * This file is part of the Centagon Build/Core package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Bauhaus\Widgets\Widget;

class Select extends Widget
{

    /**
     * Override the view path.
     * @var string
     */
    protected $view = 'build.core::components.bauhaus.input.select';

    /**
     * Get the data tags for this field.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->get('data', []);

        return implode(' ', array_map(function ($v, $k) {
            return sprintf('data-%s="%s"', $k, $v);
        }, $data, array_keys($data)));
    }

    /**
     * Get the data tags for this field.
     *
     * @return string
     */
    public function getAttributes()
    {
        $attr = $this->get('attributes', []);

        return implode(' ', array_map(function ($v, $k) {
            return sprintf('%s="%s"', $k, $v);
        }, $attr, array_keys($attr)));
    }

    /**
     * Return the old input value.
     *
     * @param  mixed  $default
     * @return mixed  The old input value
     */
    public function getOld($default = null)
    {
        if ( ! $default) {
            $default = $default ? : $this->get('selected', $this->isMultiple() ? [] : null);
        }

        return old($this->get('name'), $this->get('value', $default));
    }

    /**
     * Returns wether this select is a multiple.
     *
     * @return boolean
     */
    public function isMultiple()
    {
        return $this->get('multiple', false) == true;
    }

    /**
     * Retrieves all the Options in key=>value fashion.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->get('options', []);
    }
    
    public function isSelected($key) {
        
        if ($this->isMultiple()) {
            return in_array($key, $this->getOld());
        }
        
        return $key === $this->getOld();
    }
}
