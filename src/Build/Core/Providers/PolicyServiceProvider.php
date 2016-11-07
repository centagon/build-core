<?php

namespace Build\Core\Providers;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Color;
use Build\Core\Eloquent\Website;
use Build\Core\Policies\UserPolicy;
use Build\Core\Policies\ColorPolicy;
use Build\Core\Eloquent\Models\User;
use Build\Core\Policies\WebsitePolicy;
use Build\Core\Policies\LanguagePolicy;
use Build\Core\Eloquent\Models\Language;
use Illuminate\Contracts\Auth\Access\Gate;
use Build\Core\Policies\Language\DictionaryPolicy;
use Build\Core\Eloquent\Models\Language\Entry as LanguageEntry;
use Build\Core\Policies\Language\EntryPolicy as LanguageEntryPolicy;

class PolicyServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Color::class => ColorPolicy::class,
        Website::class => WebsitePolicy::class,
        Language::class => LanguagePolicy::class,
        Dictionary::class => DictionaryPolicy::class,
        LanguageEntry::class => LanguageEntryPolicy::class
    ];

    /**
     * @var Gate
     */
    protected $gate;

    /**
     * Boot the service provider.
     *
     * @param  Gate  $gate
     */
    public function boot(Gate $gate)
    {
        $this->gate = $gate;

        $this->registerPolicies();
    }

    /**
     * Apply all defined policies.
     */
    protected function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            $this->registerPolicy($key, $value);
        }
    }

    /**
     * @param  string  $key
     * @param  string  $policy
     */
    protected function registerPolicy($key, $policy)
    {
        $this->gate->policy($key, $policy);

        (new $policy)->defineAbilities();
    }
}