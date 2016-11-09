<?php

namespace Build\Core\Eloquent\Models\Language;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Eloquent\Model;
use Build\Core\Eloquent\Models\Language;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entry extends Model
{

    /**
     * Override the table name.
     * @var string
     */
    protected $table = 'language_entries';

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'locale', 'entry', 'value'
    ];

    /**
     * @return BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * @return BelongsTo
     */
    public function dictionary()
    {
        return $this->belongsTo(Dictionary::class);
    }

    public function translate($entry, $locale = null)
    {
        $locale = $locale ?: app()->getLocale();

        $key = sprintf('build.language.%s.%s', $locale, $entry);

        return app('cache')->rememberForever($key, function () use ($entry, $locale, $key) {
            $result = (new self)->where([
                'locale' => $locale,
                'entry' => $entry
            ])->first();

            return $result ? $result->value : $entry;
        });
    }

    /**
     * Clear all language caches.
     */
    public function invalidateCaches()
    {
        foreach (self::all() as $row) {
            app('cache')->forget(sprintf('build.language.%s.%s', $row->locale, $row->entry));
        }
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        self::saving(function ($model) {
            $model->invalidateCaches();
        });
    }
}
