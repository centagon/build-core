<?php

namespace Build\Core\Eloquent\Models;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $roleCache = [];

    /**
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * Password hashing attribute setter.
     *
     * @param  string  $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * Assign a new role to this user.
     *
     * @param  string            $name
     * @param  Website|int|null  $website
     */
    public function assignRole($name, $website = null)
    {
        // Check if the current role is the same as the assignment.
        if (($current = $this->getRole($website)) && ($current->getKey() == $name)) {
            return;
        }

        $role = Role::find($name);

        if ($name == Role::SUPER_ADMINISTRATORS) {
            $website = null;
        }

        if ($current) {
            $this->roles()->detach($current, ['website_id' => $website]);
        }

        $this->roles()->attach($role, ['website_id' => $website]);
    }

    /**
     * @param  string    $role
     * @param  int|null  $website
     */
    public function removeRole($role, $website = null)
    {
        // Determine if the user has this role.
        if (! $this->hasRole($role, $website, true)) {
            return;
        }

        $this->roles()->newPivotStatementForId($role)
            ->where('website_id', $website)
            ->delete();
    }

    /**
     * Check if the user has a certain (or multiple) role assigned.
     *
     * @param  string|array  $names
     * @param  int|null      $website
     * @param  bool          $exact
     *
     * @return bool
     */
    public function hasRole($names, $website = null, $exact = false)
    {
        if (! is_array($names)) {
            $names = [$names];
        }

        $key = implode(',', $names) . $website . (string) $exact;

        if (isset($this->roleCache[$key])) {
            return $this->roleCache[$key] > 0;
        }

        $count = $this->roles()
            ->whereIn('roles.id', $names)
            ->where(function ($query) use ($website, $exact) {
                $query->where('website_id', $website);

                if (! $exact) {
                    $query->orWhereNull('website_id');
                }
            })->count();

        $this->roleCache[$key] = $count;

        return $count > 0;
    }

    /**
     * Determine that this user is a super admin.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(Role::SUPER_ADMINISTRATORS);
    }

    /**
     * Determine that this user is an admin.
     *
     * @param  int|null  $website
     *
     * @return bool
     */
    public function isAdmin($website = null)
    {
        return $this->hasRole(Role::ADMINISTRATORS, $website);
    }

    /**
     * Get a certain role.
     *
     * @param  int   $website
     * @param  bool  $exact
     *
     * @return mixed
     */
    public function getRole($website, $exact = true)
    {
        $role = $this->roles()->where('website_id', $website)->first();

        if (! $role && ! $exact) {
            $role = $this->roles()->whereNull('website_id')->first();
        }

        return $role;
    }
}
