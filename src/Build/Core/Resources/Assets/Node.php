<?php

namespace Build\Core\Resources\Assets;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Node
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $children = [];

    /**
     * @var array
     */
    public $parents = [];

    /**
     * @param  string  $name
     */
    public function __construct($name = '')
    {
        $this->name = $name;
    }
}