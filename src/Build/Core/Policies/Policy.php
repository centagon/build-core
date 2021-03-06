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
use Build\Core\Eloquent\Traits\BelongsToWebsite;

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
    public function before(User $user, $ability, $object = null)
    {
                    
        return $this->allowsUser($user, $ability, $object);

    }
    
    /**
     * Allows for calling the policy Externally
     * 
     * @param string $ability
     * @param mixed $object
     * @param integer $websiteId
     * 
     * @return boolean
     */
    public function allows( $ability, $object = null, $websiteId = null) {
        
        $user = auth()->user();
        
        return $this->allowsUser($user, $ability, $object, $websiteId);
        
    }
    
    /**
     * Allows for calling the policy Externally
     * 
     * @param User $user
     * @param string $ability
     * @param mixed $object
     * @param integer $websiteId
     * 
     * @return boolean
     */
    public function allowsUser(User $user, $ability, $object = null, $websiteId = null) {
        
        // The almighty may enter
        if ($user->isSuperAdmin()) {
            return true;
        }

        $ability = $this->getAbilityName($ability);

        if ($this->objectBelongsToWebsite($object)) {
            
            $websiteId = $object->website_id;
            
        }
        
        if (empty($websiteId)) {
            
            $websiteId = $this->discoverWebsiteId();
            
        }
        
        // TODO: FIX THIS HACK !
        $roles = array_merge(['superadmin'], array_get($this->capabilities, $ability, []));
        
        // Check the user's capabilities.
        return $user->hasRole($roles, $websiteId);
        
    }
    
    /**
     * Check if an object belongs to a website
     * @param mixed $object An object to check
     * @return boolean Returns true when the object is website-aware
     */
    private function objectBelongsToWebsite($object) {
        
        if (is_null($object)) {
            return false;
        }
        
        if (!is_object($object)) {
            return false;
        }
        
        if ( has_trait($object, BelongsToWebsite::class) ) {
            return true;
        }
        
        return false;
    }
    
    /**
     * returns the discovered websiteId
     * 
     * @return mixed Returns an integer value or null
     */
    private function discoverWebsiteId() {
        
        return ($website = Discovery::backendWebsite()) ? $website->getKey() : null;
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
