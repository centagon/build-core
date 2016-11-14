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
     * @param  string|null  $action
     *
     * @return mixed
     */
    public function make($entity, $action = null)
    {
        if ($action === null) {
            if ( ! str_contains($entity, '@')) {
                throw new \InvalidArgumentException('No entity action provided.');
            }

            list($entity, $action) = explode('@', $entity);
        }

        return (new $entity)->setMethod($action);
    }
}
