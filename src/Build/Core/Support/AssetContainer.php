<?php

namespace Build\Core\Support;

use Build\Core\Eloquent\Models\Asset;
use Build\Core\Eloquent\Models\Website;

class AssetContainer
{
    /**
     * The key to create the cache on.
     *
     * @var string
     */
    static $cacheKey = 'asset-collection.';

    /**
     * Warm the asset container caches by the given website.
     *
     * @param  \Build\Core\Eloquent\Models\Website $website
     * @return void
     */
    public static function warm(Website $website)
    {
        $cacheKey = static::$cacheKey.$website->getKey();

        cache()->rememberForever($cacheKey, function () use ($website) {
            $assets = [];

            foreach ($website->assets as $asset) {
                $assets[$asset->getKey()] = $asset;
            }

            return $assets;
        });
    }

    /**
     * Flush to asset container cache for the given website.
     *
     * @param \Build\Core\Eloquent\Models\Website $website
     * @return void
     */
    public static function flush(Website $website)
    {
        cache()->forget(
            static::$cacheKey.$website->getKey()
        );
    }

    /**
     * Get the cached asset. If the asset isn't cached we try to
     * safely fall back to get the asset from the eloquent model.
     *
     * @param  int $id
     * @return \Build\Core\Eloquent\Models\Asset|null
     */
    public static function get($id)
    {
        $cache = cache()->get(
            static::$cacheKey.request()->website()->getKey()
        );

        return array_get($cache, $id) ?: Asset::find($id);
    }
}
