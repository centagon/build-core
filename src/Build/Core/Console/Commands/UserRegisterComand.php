<?php

namespace Build\Core\Console\Commands;

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

class UserRegisterComand extends \Illuminate\Console\Command
{

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'build:user:register {user} {email} {--password} {--register}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Register a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $password = $this->option('password') ?: $this->secret('What is the password?');
        $name = $this->argument('name');
        $email = $this->argument('email');
        $register = $this->option('register') ?: $this->confirm('Do you wish to register this user? [y|N]');

        if ($register) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => $password
            ]);

            $user->assignRole(Role::SUPER_ADMINISTRATORS);

            $this->info('Done registering ' . $name);
        }
    }
}
