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

    /**
     * Holds the widget attributes.
     * @var array
     */
    protected $attributes = [];

    public function renderedAttributes()
    {
        return new HtmlString(implode(' ', array_map(function ($key, $value) {
            // Does the string start with a colon? That means that
            // we want to get the value set by the builder and
            // will not provide one on our own.
            if (starts_with($value, ':')) {
                $value = $this->get($key);
            }

            // When the string starts with an at (@) symbol that means
            // that we want to render/modify the attribute ourselfs.
            if (starts_with($value, '@')) {
                $modifier = 'get' . studly_case(substr($value, 1)) . 'Modifier';

                // Can we call the modifier method on the field?
                if ( ! method_exists($this, $modifier)) {
                    throw new \InvalidArgumentException("Cannot reach the `$modifier` modifier.");
                }

                return $this->{$modifier}();
            }

            // Just return the key value pair (html style).
            return sprintf('%s="%s"', $key, $value);
        }, array_keys($this->attributes), $this->attributes)));
    }
}
