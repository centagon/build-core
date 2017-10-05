<?php

namespace Build\Core\Repositories;

use Build\Core\Eloquent\Models\Website;
use Build\Core\Contracts\Repositories\Website as Contract;

class WebsiteRepository implements Contract
{
    /**
     * The website model.
     *
     * @var \Build\Core\Eloquent\Models\Website
     */
    protected $model;

    /**
     * Create a new website repository instance.
     *
     * @param \Build\Core\Eloquent\Models\Website $model
     * @return void
     */
    public function __construct(Website $model)
    {
        $this->model = $model;
    }

    /**
     * Get all registered websites.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWebsites()
    {
        return $this->model->get();
    }

    /**
     * Update the given website.
     *
     * @param  \Build\Core\Eloquent\Models\Website  $website
     * @param  array  $payload
     * @return \Build\Core\Eloquent\Models\Website
     */
    public function updateWebsite(Website $website, $payload = [])
    {
        $website->update($payload);

        if ($language = array_get($payload, 'language_id')) {
            $website->language()->associate($language);
        }

        $website->save();

        return $website;
    }
}
