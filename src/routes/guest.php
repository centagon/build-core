<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::resource('sessions', 'Auth\SessionsController', [
    'only' => ['create', 'store']
]);

Route::get('sign-out', [
    'as' => 'admin.sessions.destroy',
    'uses' => 'Auth\SessionsController@destroy'
]);

Route::get('sign-in', [
    'as' => 'admin.sessions.create',
    'uses' => 'Auth\SessionsController@create'
]);

Route::get('install', [
    'as' => 'install',
    'uses' => 'InstallController@index'
]);