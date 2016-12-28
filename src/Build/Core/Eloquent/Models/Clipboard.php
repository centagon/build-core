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

use Build\Core\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Clipboard extends Model
{

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'clipboard_data', 'slug', 'type', 'is_persistent',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param  Builder  $query
     * @param  string   $slug
     */
    public function scopeBySlug($query, $slug)
    {
        $query->where('slug', str_slug($slug));
    }

    /**
     * @param  Builder  $query
     * @param  string   $type
     */
    public function scopeByType($query, $type)
    {
        $query->where('type', $type);
    }

    /**
     * Retreive the clipboard data attribute.
     *
     * @param  mixed  $value
     *
     * @return mixed
     */
    public function getClipboardDataAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Ensure that the data is json encode.
     *
     * @param  mixed  $value
     */
    public function setClipboardDataAttribute($value)
    {
        if ( ! is_string($value)) {
            $value = json_encode($value);
        }

        $this->attributes['clipboard_data'] = $value;
    }

    /**
     * Force slug the slug attribute.
     *
     * @param  string  $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }

    public function fetch()
    {
        throw new \Exception('not yet implemented');
    }

    /**
     * @param  string  $slug
     * @param  string  $type
     * @param  mixed   $data
     * @param  bool    $persistent
     *
     * @return static
     */
    public static function store($slug, $type, $data, $persistent = false)
    {
        $clipboard = new static([
            'clipboard_data' => $data,
            'slug' => $slug,
            'type' => $type,
            'is_persistent' => $persistent
        ]);

        $clipboard->user()->associate(auth()->user()->getKey());
        $clipboard->save();

        return $clipboard;
    }
}