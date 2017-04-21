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

use Build\Core\Bauhaus\Widgets\Input\Generic;
use Carbon;

class DateTime extends Generic
{

    /**
     * Override the view path.
     * @var string
     */
    protected $view = 'build.core::components.bauhaus.input.datetime';
    
    /**
     * Set the field attributes.
     * @var array
     */
    protected $attributes = [
        'type' => 'datetime-local',
        'name' => ':name',
        'value' => ':value',
        'placeholder' => ':placeholder'
    ];
    
    public function getValue() {
        $value = $this->value ? : null;
        
        if ($value) {
            $value = format_datetime_local(Carbon\Carbon::createFromTimestamp(strtotime($value)));
        }
        
        return old($this->name, $value);
    }
    
}
