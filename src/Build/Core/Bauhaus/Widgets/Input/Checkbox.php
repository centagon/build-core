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

class Checkbox extends Widget
{

    /**
     * Override the view path.
     * @var string
     */
    protected $view = 'build.core::components.bauhaus.input.checkbox';

    /**
     * Set the field attributes.
     * @var array
     */
    protected $attributes = [
        'type' => 'checkbox',
        'name' => ':name',
        'value' => '1',
        'checked' => '@checked'
    ];

    /**
     * Checked state modifier.
     *
     * @return string
     */
    protected function getCheckedModifier()
    {
        return old($this->name, $this->value) == 1 ? 'checked' : '';
    }
}
