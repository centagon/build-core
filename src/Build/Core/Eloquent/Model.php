<?php

namespace Build\Core\Eloquent;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Events\ModelSavedEvent;
use Build\Core\Eloquent\Scope\Registry;

class Model extends \Illuminate\Database\Eloquent\Model
{

    /**
     * @param  \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeFiltered($query)
    {
        $clone = clone $query;

        $scopes = Registry::getInstance()->filters();

        if ($scopes->count() > 0) {
            foreach ($scopes as $scope => $values) {
                if ( ! empty($values)) {
                    try_method($this, 'filter' . studly_case($scope), [
                        $query, $values,
                    ]);
                }
            }

            if (($result = ($clone->count() - $query->count())) > 0) {
                view()->share('scope_result', $result);
            }
        }
    }

    /**
     * Get the cache for specific for this model.
     *
     * @param  string|int|null  $id
     *
     * @return string
     */
    public function getCacheKey($id = null)
    {
        $key = $this->getQualifiedModelName();

        // When supplied, append the record id to the cache
        // key for better unique record caching.
        if ($id !== null) {
            $key .= '.' . $id;
        }

        return $key;
    }

    /**
     * Retrieve the qualified model instance name.
     *
     * @param  mixed  $instance
     * @return string
     */
    public function getQualifiedModelName($instance = null)
    {
        $namespace = $instance ?: get_class($this);

        // Transform namespace back-slashes to namespace dashes.
        return strtolower(str_replace('\\', '-', $namespace));
    }

    /**
     * Handle boot events.
     */
    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            event(new ModelSavedEvent($model));
        });
    }
}