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
        Cache::forget($event->model->getCacheKey());
    }
}