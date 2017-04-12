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

use Illuminate\Database\Query\Builder;
use Build\Core\Support\Facades\Discovery;
use Build\Core\Eloquent\Traits\Activatable;
use Build\Core\Eloquent\Models\Language\Entry;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Language extends \Build\Core\Eloquent\Model
{

    use Activatable;

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'name', 'locale', 'is_main', 'is_active'
    ];

    /**
     * @return HasMany
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * @return BelongsToMany
     */
    public function websites()
    {
        return $this->belongsToMany(Website::class);
    }

    /**
     * Scope the query to only return the main language.
     *
     * @param  Builder  $query
     */
    public function scopeMain($query)
    {
        $query->where('is_main', true)->limit(1);
    }

    public function scopeByWebsite($query)
    {
        if ($website = Discovery::backendWebsite()) {
            $query
                ->select('languages.*', 'websites.id AS website_id')
                ->leftJoin('websites', 'languages.id', '=', 'websites.language_id')
                ->where('websites.id', $website->getKey());
        }
    }
}
