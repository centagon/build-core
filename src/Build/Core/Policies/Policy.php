<?php

namespace Build\Core\Policies;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\User;
use Illuminate\Support\Facades\Gate;
use Build\Core\Support\Facades\Discovery;

abstract class Policy
{

    /**
     * @var null|string
     */
    protected $policyName = null;

    /**
     * Handle the policy check.
     *
     * @param  User    $user
     * @param  string  $ability
     *
     * @return bool
     */
    public function before(User $user, $ability)
    {
        // The almighty may enter
        if ($user->isSuperAdmin()) {
            return true;
        }

        $ability = $this->getAbilityName($ability);

        $websiteId = ($website = Discovery::backendWebsite())
            ? $website->getKey()
            : null;

        // Check the user's capabilities.
        return $user->hasRole(array_get($this->capabilities, $ability, []), $websiteId);
    }

    /**
     * Define the abilities belonging to this policy.
     */
    public function defineAbilities()
    {
        // Did we define the policy capabilities?
        if ( ! property_exists($this, 'capabilities')) {
            throw new \InvalidArgumentException('No policy capabilities defined on ' . get_class($this));
        }

        foreach (array_keys($this->capabilities) as $ability) {
            $name = $this->getPolicyName($ability);

            Gate::define($name, function ($user, $object = null, $param = null) use ($ability, $name) {
                return is_null($object)
                    ? $this->before($user, $ability)
                    : $user->can($ability, $object, $param);
            });
        }
    }

    /**
     * Get the name of the policy.
     *
     * @param  null|string  $ability
     *
     * @return string
     */
    protected function getPolicyName($ability = null)
    {
        $name = $this->policyName
            ?: str_replace('policy', '', strtolower(class_basename(static::class)));

        return $ability
            ? implode('-', [$ability, $name])
            : $name;
    }

    /**
     * @param  string  $ability
     *
     * @return string
     */
    protected function getAbilityName($ability)
    {
        return str_replace('-' . $this->getPolicyName(), '', $ability);
    }
}
