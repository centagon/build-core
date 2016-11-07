<?php

namespace Build\Core\Eloquent\Models;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;
use Build\Core\Support\Color as Support;

class Color extends Model
{

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'name', 'color'
    ];

    /**
     * Sluggify the name on save/update.
     *
     * @param  string  $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = str_slug($value);
    }

    /**
     * Convert the color value to hex.
     *
     * @return string
     */
    public function getHexColorAttribute()
    {
        $color = $this->attributes['color'];

        return Support::toHex($color);
    }

    /**
     * Convert the color value to rgb.
     *
     * @return string
     */
    public function getRgbColorAttribute()
    {
        $color = $this->attributes['color'];

        return Support::toRgb($color);
    }

    public function getBestContrastAttribute()
    {
        return Support::bestContrast($this->attributes['color']);
    }
}