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

class RegisterUserCommand extends \Illuminate\Console\Command
{

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'build:core:register-user {user} {email} {--password} {--register}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Register a new user';
}
