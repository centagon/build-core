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

use Illuminate\Database\Query\Builder;
use Build\Core\Events\ModelSavedEvent;
use Build\Core\Eloquent\Scope\Registry;

class Model extends \Illuminate\Database\Eloquent\Model
{

    /**
     * @param  Builder  $query
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
     * Handle boot events.
     */
    public static function boot()
    {
        static::saved(function ($model) {
            event(new ModelSavedEvent($model));
        });
    }
}