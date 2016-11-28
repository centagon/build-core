<?php

namespace Build\Core\Http\Routing;

/**
 * This file is part of the Centagon Build/Core package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\Website;
use Illuminate\Database\Eloquent\Collection;

class Discovery
{

    /**
     * @var null|Website
     */
    protected $website;

    /**
     * @var null|Website
     */
    protected $backendWebsite;

    /**
     * @var null|Language
     */
    protected $language;

    /**
     * @var null|Language
     */
    protected $backendLanguage;

    /**
     * Get the current website.
     *
     * @return Website|null
     */
    public function website()
    {
        if ($this->website) {
            return $this->website;
        }

        $url = $this->getUrl();

        try {
            // First try to find exact matches.
            $this->website = Website::activated()
                ->select([
                    'id', 'domain',
                ])
                ->with(['language' => function ($q) {
                    $q->select('id');
                }])
                ->byDomain($url)
                ->sorted()
                ->firstOrFail();
        } catch (\RuntimeException $e) {

            // When we're unable to find the exact matche we'll try to figure out the best match.
            // This is done by sorting all the domains by length (sortest first) and looping
            // through those results untill we're able to find a new `exact` match. This
            // will be our current domain. Nothing is returned when nothing is found.
            $sites = Website::activated()
                ->with(['language' => function ($q) {
                    $q->select('id');
                }])
                ->sorted()
                ->get();

            foreach ($sites as $site) {
                if ((bool) strstr(str_finish($url, '/'), str_finish($site->domain, '/')) === true) {
                    $this->website = $site;
                    break;
                }
            }
        }

        return $this->website;
    }

    /**
     * Get the current language.
     *
     * @return Language|null
     */
    public function language()
    {
        if ( ! $this->website) {
            return null;
        }

        return $this->website->language;
    }

    /**
     * Get the websites that the user has access to.
     *
     * @return Collection|array
     */
    public function userWebsites()
    {
        if ( ! $user = request()->user()) {
            return [];
        }

        // Check if the user has a default Role ; If so, he has access to any website
        if ($user->getRole(null)) {
            $websites = Website::all();
        } else {
            // Filter the websites that the user has access to
            $websites = Website::all()->filter(function ($value) use ($user) {
                return $user->getRole($value->id, true)
                    ? true
                    : false;
            });
        }

        return $websites;
    }

    /**
     * Retreive the current website the user is logged into.
     *
     * @param  Website|null  $fallback
     *
     * @return Website|null
     */
    public function backendWebsite($fallback = null)
    {
        if ($this->backendWebsite) {
            return $this->backendWebsite;
        }

        if (($this->backendWebsite = $this->discoverBackendWebsiteFromInput())) {
            return $this->backendWebsite;
        }

        if (($this->backendWebsite = $this->discoverBackendWebsiteFromSession())) {
            return $this->backendWebsite;
        }

        return $fallback;
    }

    /**
     * @return null|Website
     */
    public function discoverBackendWebsiteFromInput()
    {
        if (($siteId = request()->get('backend.website_id'))) {
            return Website::where('id', $siteId)->first();
        }

        return null;
    }

    /**
     * @return null|Website
     */
    public function discoverBackendWebsiteFromSession()
    {
        if (($siteId = session('backend.website_id'))) {
            return Website::where('id', $siteId)->first();
        }

        return null;
    }

    /**
     * Get the (parsed) current url.
     *
     * @return string
     */
    public function getUrl()
    {
        $url = request()->url();

        if (in_array('_', request()->segments())) {
            $url = url()->previous();
        }

        return str_replace(['http://', 'https://'], '', $url);
    }

    /**
     * Get the current slug (url minus domain).
     *
     * @return string
     */
    public function getSlug()
    {
        if ( ! $this->website) {
            return false;
        }

        return trim(str_replace($this->website->domain, '', $this->getUrl()), '/') ?: '/';
    }
}
