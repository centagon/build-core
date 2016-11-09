<?php

namespace Build\Core\Bauhaus\Widgets;

/**
 * This file is part of the Centagon Build/Bauhaus package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Bauhaus\Mapper;
use Illuminate\Support\HtmlString;

/**
 * Class Widget
 * @package Build\Bauhaus\Widgets
 */
abstract class Widget extends Mapper
{

    protected $attributes = [];

    public function renderedAttributes()
    {
        return implode(' ', array_map(function ($key, $value) {
            if (starts_with($value, ':')) {
                $value = $this->get($key);
            }

            if (! starts_with($value, '@')) {
                $string = sprintf('%s=%s', $key, $value);
            } else {
                $modifier = 'get' . studly_case(substr($value, 1)) . 'Modifier';

                if (! method_exists($this, $modifier)) {
                    throw new \InvalidArgumentException("Cannot reach the `$modifier` modifier.");
                }

                $string = $this->{$modifier}();
            }

            return $string;
        }, array_keys($this->attributes), $this->attributes));
    }
}
