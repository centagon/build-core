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

class Hidden extends Generic
{

    /**
     * Set the field attributes.
     * @var array
     */
    protected $attributes = [
        'type' => 'hidden',
        'name' => ':name',
        'value' => ':value'
    ];
}
