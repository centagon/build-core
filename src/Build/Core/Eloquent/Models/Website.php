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
use Build\Core\Support\Facades\Context;
use Build\Core\Support\Facades\Discovery;
use Build\Core\Eloquent\Traits\Groupable;
use Build\Core\Eloquent\Traits\Activatable;

class Website extends \Build\Core\Eloquent\Model
{

    use Groupable;
    use Activatable;

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'name', 'domain', 'color'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Scope the query by a given domain.
     *
     * @param  Builder  $query
     * @param  string   $domain
     */
    public function scopeByDomain($query, $domain)
    {
        $query->where('domain', $domain);
    }

    /**
     * Sort the query based on the domain length (shorty's first y'all).
     *
     * @param  Builder  $query
     */
    public function scopeSorted($query)
    {
        $query->orderByRaw('LENGTH(`domain`) DESC');
    }

    /**
     * Get the full url to this domain.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return $this->url();
    }

    /**
     * Force strip the scheme from the given domain.
     *
     * @param  string  $value
     */
    public function setDomainAttribute($value)
    {
        $value = preg_replace('/^https?:\/\//', '', $value);

        $this->attributes['domain'] = $value;
    }

    /**
     * Get the full url of the website.
     *
     * @param  string|null  $slug
     *
     * @return string
     */
    public function url($slug = null)
    {
        $domain = sprintf('http%s://%s', request()->isSecure() ? 's' : '', trim($this->domain, '/'));

        if ($slug !== null) {
            $domain .= '/' . $slug;
        }

        return $domain;
    }
}
