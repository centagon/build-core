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

use Build\Core\Eloquent\Models\User;

class UserTableSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        $user = User::create([
            'name' => 'super-admin',
            'email' => 'super@admin.com',
            'password' => 'letmein'
        ]);

        $user->assignRole('superadmin');
    }
}