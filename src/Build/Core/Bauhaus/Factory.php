<?php

namespace Build\Core\Bauhaus;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Factory
{

    /**
     * @param  string       $entity
     * @param  string|null  $method
     *
     * @return mixed
     */
    public function make($entity, $method = null)
    {
        if (! $method) {
            list($entity, $method) = explode('@', $entity);
        }

        return (new $entity)->setMethod($method);
    }
}