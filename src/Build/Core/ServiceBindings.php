<?php

namespace Build\Core;

trait ServiceBindings
{
    /**
     * All of the service bindings for Build\Core.
     *
     * @var array
     */
    protected $bindings = [
        Contracts\Repositories\Website::class => Repositories\WebsiteRepository::class,
    ];
}
