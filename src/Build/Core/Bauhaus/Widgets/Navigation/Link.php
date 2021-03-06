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

class Link extends Widget
{

    /**
     * Override the view path.
     * @var string
     */
    protected $view = 'build.core::components.bauhaus.navigation.link';
    
    public function getUrl() {
        $to = $this->get('to');

        if (!is_callable($to)) {
            return $to;
        }
        
        return $to($this);
    }
}
