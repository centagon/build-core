<?php

namespace Build\Core\Listeners;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\Facades\Cache;
use Build\Core\Events\ModelSavedEvent;

class ModelSaved
{

    /**
     * @param  ModelSavedEvent  $event
     */
    public function handle(ModelSavedEvent $event)
    {
        $model = $event->model;

        // Forget the model's 'master' cache.
        Cache::forget($model->getCacheKey());

        // Forget the model's key specific cache (when applicable).
        Cache::forget($model->getCacheKey($model->getKey()));
    }
}