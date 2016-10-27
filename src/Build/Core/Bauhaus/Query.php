<?php

namespace Build\Core\Bauhaus;

/**
 * This file is part of the Centagon Build/Bauhaus package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Closure;

/**
 * Class Query
 * @package Build\Entity
 */
class Query
{

    /**
     * @var callable
     */
    protected $query;

    /**
     * Create a new Query instance.
     *
     * @param  callable  $query
     */
    public function __construct(Closure $query)
    {
        $this->setQuery($query);
    }

    /**
     * Get the current query.
     *
     * @return callable
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set the current query.
     *
     * @param  callable  $query
     *
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Execute the query.
     *
     * @return mixed
     */
    public function execute()
    {
        $query = $this->getQuery();

        return $query();
    }
}
