<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get('/', 'DashboardController@index')->name('admin.dashboard');

require __DIR__ . '/guarded/assets.php';
require __DIR__ . '/guarded/color.php';
require __DIR__ . '/guarded/groups.php';
require __DIR__ . '/guarded/language.php';
require __DIR__ . '/guarded/modules.php';
require __DIR__ . '/guarded/user.php';
require __DIR__ . '/guarded/website.php';
require __DIR__ . '/guarded/springboard.php';