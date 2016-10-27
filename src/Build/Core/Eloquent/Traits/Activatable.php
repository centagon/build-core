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

use Illuminate\Database\Eloquent\Builder;

trait Activatable
{

    /**
     * Activate the current model.
     */
    public function activate()
    {
        $this->setAttribute($this->getActivatedColumn(), true);
    }

    /**
     * Deactivate the current model.
     */
    public function deactivate()
    {
        $this->setAttribute($this->getActivatedColumn(), false);
    }

    /**
     * Scope the current query on activated entries.
     *
     * @param  Builder  $query
     */
    public function scopeActivated(Builder $query)
    {
        $query->where($this->getActivatedColumn(), true);
    }

    /**
     * Scope the current query on de-activated entries.
     *
     * @param  Builder  $query
     */
    public function scopeDeactivated(Builder $query)
    {
        $query->where($this->getActivatedColumn(), false);
    }

    /**
     * Get the activated column name.
     *
     * @return string
     */
    protected function getActivatedColumn(): string
    {
        return property_exists($this, 'activatedColumn')
            ? $this->activatedColumn
            : 'is_active';
    }
}
