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

class Radio extends Widget
{

    /**
     * Override the view path.
     * @var string
     */
    protected $view = 'build.core::components.bauhaus.input.radio';

    public function getOptions()
    {
        return $this->get('options', []);
    }

    public function isChecked($key)
    {
        return $key == $this->getOld();
    }

    public function getOld($default = null)
    {
        if (! $default) {
            $default = $default ?: $this->get('checked', null);
        }

        return old($this->get('name'), $this->get('value', $default));
    }
}
