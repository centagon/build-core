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

use Build\Core\Console\Commands\UserRegisterComand;

class ConsoleServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * @var array
     */
    protected $commands = [
        UserRegisterComand::class
    ];

    /**
     * Registger the console commands.
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
