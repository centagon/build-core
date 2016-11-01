<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get('users/{user}/sidebar/roles', [
    'as' => 'admin.users.sidebar.roles',
    'uses' => 'UsersController@rolesSidebar'
]);

Route::put('users/{user}/sidebar/roles', [
    'as' => 'admin.users.sidebar.roles.update',
    'uses' => 'UsersController@updateRoles'
]);

Route::resource('users', 'UsersController', [
    'except' => ['show']
]);