<?php

namespace Build\Core\Eloquent\Seeders;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\Role;

class RolesTableSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        $roles = [
            'superadmin', 'admin', 'editor',
            'author', 'contributor'
        ];

        foreach ($roles as $role) {
            Role::create(['id' => $role]);
        }
    }
}