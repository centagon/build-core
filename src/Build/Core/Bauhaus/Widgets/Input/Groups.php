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

use Build\Core\Eloquent\Models\Group;
use Build\Core\Bauhaus\Widgets\Widget;

class Groups extends Widget
{

    /**
     * Override the view path.
     * @var string
     */
    protected $view = 'build.core::components.bauhaus.input.groups';

    public function getGroups()
    {
        if ( ! $this->has('model')) {
            return [];
        }

        return Group::byType($this->model)->get();
    }
}