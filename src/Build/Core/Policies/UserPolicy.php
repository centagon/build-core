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

use Build\Core\Eloquent\Models\Role;
use Build\Core\Eloquent\Models\User;

class UserPolicy extends Policy
{

    /**
     * Define the policy capabilities.
     * @var array
     */
    protected $capabilities = [
        'login'        => ['admin', 'editor', 'author', 'contributor'],
        'index'        => ['admin'],
        'create'       => ['admin'],
        'edit'         => ['admin'],
        'delete'       => ['admin'],
        'manage_roles' => ['admin'],
        'update_roles' => ['admin'],
    ];

    /**
     * Protect updating the user roles.
     *
     * @param  User   $user
     * @param  array  $parameters
     *
     * @return bool
     */
    public function updateRole(User $user, array $parameters)
    {
        list(, $role, $website) = $parameters;

        return ($user->isSuperAdmin() || ($user->isAdmin($website) && ($role !== Role::SUPER_ADMINISTRATORS)));
    }

    /**
     * @param  User  $user
     *
     * @return bool
     */
    public function manageUserRoles(User $user)
    {
        return $user->isSuperAdmin();
    }
}
