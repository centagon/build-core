<?php

namespace Build\Core\Bauhaus\Widgets\Navigation;

/**
 * This file is part of the Centagon Build/Core package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Bauhaus\Widgets\Widget;

class Button extends Widget
{

    const STYLE_SECONDARY = 'secondary';
    const STYLE_PRIMARY = 'primary';
    const STYLE_SUCCESS = 'success';
    const STYLE_ALERT = 'alert';

    /**
     * Override the view path.
     * @var string
     */
    protected $view = 'build.core::components.bauhaus.navigation.button';
}