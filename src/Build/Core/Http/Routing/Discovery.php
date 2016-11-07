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
     * @deprecated 2.0.0
     * @return Website|null
     */
    public function discoverWebsite()
    {
        return $this->website();
    }

    /**
     * Get the current website.
     *
     * @return Website|null
     */
    public function website()
    {
        $url = $this->getUrl();

        try {
            // First try to find exact matches.
            $this->website = Website::activated()
                ->with([
                    'language'
                ])
                ->byDomain($url)
                ->sorted()
                ->firstOrFail();
        } catch (\RuntimeException $e) {

            // When we're unable to find the exact matche we'll try to figure out the best match.
            // This is done by sorting all the domains by length (sortest first) and looping
            // through those results untill we're able to find a new `exact` match. This
            // will be our current domain. Nothing is returned when nothing is found.
            $sites = Website::activated()
                ->with([
                    'language'
                ])
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

    public function discoverLanguage()
    {

    }

    public function language()
    {
        if (! $this->website) {
            return null;
        }

        return $this->website->language;
    }

    public function discoverUserWebsites()
    {
        $user = request()->user();
        if ( !$user ) return [];

        // Check if the user has a default Role ; If so, he has access to any website
        if ( $user->getRole(null) ) {
            $websites = Website::all();
        } else {
            // Filter the websites that the user has access to
            $websites = Website::all()->filter( function ($value) use ($user) {
                return ($user->getRole($value->id, true) ? true:false);
            });
        }
        return $websites;
    }

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
     * @param null $fallback
     * @return Website|null
     * @deprecated 2.0
     */
    public function discoverBackendWebsite($fallback = null)
    {
        return $this->backendWebsite($fallback = null);
    }

    public function discoverBackendWebsiteFromInput()
    {
        if (($siteId = request()->get('backend.website_id'))) {
            return Website::where('id', $siteId )->first();
        }

        return null;
    }

    public function discoverBackendWebsiteFromSession() {

        if (($siteId = session('backend.website_id'))) {
            return Website::where('id', $siteId )->first();
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
        $this->discoverWebsite();

        if (! $this->website) {
            return false;
        }

        return trim(str_replace($this->website->domain, '', $this->getUrl()), '/') ?: '/';
    }
}