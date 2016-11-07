<?php

namespace Build\Core\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Color
{

    public static function bestContrast($color)
    {
        if (! self::isRgb($color)) {
            $color = self::toRgb($color, true);
        }

        if (is_string($color)) {
            $color = self::toRgbArray($color);
        }

        $yiq = (($color['r'] * 299) + ($color['g'] * 587) + ($color['b'] * 114)) / 1000;

        return ($yiq >= 128) ? 'black' : 'white';
    }

    /**
     * Determine that the given color is an rgb color.
     *
     * @param  string  $color
     *
     * @return bool
     */
    public static function isRgb($color)
    {
        return starts_with($color, 'rgb');
    }

    /**
     * Determine that the given color is a hex color.
     *
     * @param  string  $color
     *
     * @return bool
     */
    public static function isHex($color)
    {
        return starts_with($color, '#');
    }

    /**
     * Convert a hex color to an rgb color.
     *
     * @param  string  $color
     *
     * @return string
     */
    public static function toRgb($color, $outputArray = false)
    {
        // Is this already an rgb color?
        if (self::isRgb($color)) {
            return $color;
        }

        list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");

        if ($outputArray) {
            return compact('r', 'g', 'b');
        }

        return 'rgb(' . implode(', ', [$r, $g, $b]) . ')';
    }

    public static function toRgbArray($color)
    {
        $color = explode(',', str_replace(['rgba', 'rgb', '(', ')'], '', $color));

        list($r, $g, $b) = $color;

        return compact('r', 'g', 'b');
    }

    /**
     * Convert a color to a hex value.
     *
     * @param  string|array  $color
     *
     * @return string
     */
    public static function toHex($color)
    {
        // Is this already a hex color?
        if (self::isHex($color)) {
            return $color;
        }

        if (! is_array($color)) {
            $color = array_values(self::toRgbArray($color));
        }

        list($r, $g, $b) = $color;

        return '#' . sprintf('%02x', $r) . sprintf('%02x', $g) . sprintf('%02x', $b);
    }
}