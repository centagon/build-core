<?php

namespace Build\Core\Bauhaus\Widgets;

/**
 * This file is part of the Centagon Build/Core package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Bauhaus\Widgets\Widget;

class Partial extends Widget
{

    /**
     * Override the view path.
     * @var string
     */
    protected $view = 'build.core::components.bauhaus.partial';
}
