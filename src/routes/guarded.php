<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get('/', function () {
    return view('build.core::screens.dashboard');
})->name('admin.dashboard');

require __DIR__ . '/guarded/website.php';