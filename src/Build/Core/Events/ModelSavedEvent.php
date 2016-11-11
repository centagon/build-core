<?php

namespace Build\Core\Events;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Model;

class ModelSavedEvent
{

    public $model;

    /**
     * @param  Model  $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}