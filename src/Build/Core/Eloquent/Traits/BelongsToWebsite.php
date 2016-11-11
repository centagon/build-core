<?php

namespace Build\Core\Eloquent\Traits;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\Website;
use Build\Core\Support\Facades\Context;
use Build\Core\Support\Facades\Discovery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToWebsite
{

    /**
     * @return BelongsTo
     */
    public function website()
    {
        return $this->belongsTo(Website::class, $this->getQualifiedWebsiteIdColumn());
    }

    /**
     * @param  Builder  $query
     * @param  null|int|Website  $website
     */
    public function scopeByWebsite($query, $website = null)
    {
        if (is_numeric($website)) {
            $website = Website::findOrFail($website);
        }

        if (is_null($website)) {
            if (Context::isFrontend()) {
                $website = Discovery::website();
            } else {
                $website = Discovery::backendWebsite();
            }
        }

        $query->where($this->getQualifiedWebsiteIdColumn(), $website->getKey());
    }

    /**
     * @return string
     */
    protected function getQualifiedWebsiteIdColumn()
    {
        return 'website_id';
    }
}
