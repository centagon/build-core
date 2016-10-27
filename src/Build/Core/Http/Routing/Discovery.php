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
    protected $website = null;
    protected $backendWebsite = null;

    public function discoverWebsite()
    {
        $url = $this->getUrl();

        try {
            // First try to find exact matches.
            $this->website = Website::activated()
                ->byDomain($url)
                ->sorted()
                ->firstOrFail();
        } catch (\RuntimeException $e) {
            // When we're unable to find the exact matches we'll try to figure out the best match.
            // This is done by sorting all the domains by length (sortest first) and looping
            // through those results untill we find the new `exact` match. This will be our
            // current domain. Nothing is returned when nothing is found.
            $sites = Website::activated()->sorted()->get();

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

    public function discoverUserWebsites()
    {

    }

    public function discoverBackendLanguage($fallback = null)
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

    public function discoverBackendWebsiteFromInput()
    {
        if (($siteId = request()->get(config('build.cms.backendsession.input_key')))) {
            return Website::where('id', $siteId )->first();
        }

        return null;
    }

    public function discoverBackendWebsiteFromSession() {

        if (($siteId = session(config('build.cms.backendsession.session_key')))) {
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

    public function discoverBackendWebsite()
    {

    }
}