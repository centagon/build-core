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
     * Get the data tags for this field
     * @return string
     */
    public function getAttributes()
    {
        $attr = $this->get('attributes', []);

        return implode(' ', array_map(function ($v, $k) {
            return sprintf('%s="%s"', $k, $v);
        }, $attr, array_keys($attr)));
    }
}
