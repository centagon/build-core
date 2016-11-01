<?php

namespace Build\Core\Bauhaus\Support;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Row extends \Illuminate\Support\Collection
{

    /**
     * Holds the row key.
     * @var mixed
     */
    protected $key;

    /**
     * Set the row key.
     *
     * @param  mixed  $key
     *
     * @return $this
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get the row key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }
}