<?php

namespace Build\Core\Contracts\Repositories;

use Build\Core\Eloquent\Models\Website as Model;

interface Website
{
    /**
     * Get all registered websites.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWebsites();

    /**
     * Update the given website.
     *
     * @param  \Build\Core\Eloquent\Models\Website  $website
     * @param  array  $payload
     * @return \Build\Core\Eloquent\Models\Website
     */
    public function updateWebsite(Model $website, $payload = []);
}
