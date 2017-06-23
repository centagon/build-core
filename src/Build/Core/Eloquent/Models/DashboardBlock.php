<?php

namespace Build\Core\Eloquent\Models;

use Build\Core\Eloquent\Model;
use Build\Core\Eloquent\Traits\BelongsToWebsite;

/**
 * @property int width
 * @property int height
 * @property int x
 * @property int y
 */
class DashboardBlock extends Model
{
    use BelongsToWebsite;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'color', 'width', 'height', 'x', 'y',
        'content', 'image', 'button_label', 'button_url',
    ];

    /**
     * Render the block html attributes.
     *
     * @return string
     */
    public function render_attributes(): string
    {
        $attributes = [
            'data-gs-id' => $this->getKey(),
            'data-gs-width' => $this->width,
            'data-gs-height' => $this->height,
            'data-gs-x' => $this->x,
            'data-gs-y' => $this->y,
        ];

        return implode(' ', array_map(function ($key, $val) {
            return "$key=\"$val\"";
        }, array_keys($attributes), array_values($attributes)));
    }
}
