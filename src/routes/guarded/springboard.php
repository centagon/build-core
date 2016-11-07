<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get('springboard', 'Auth\SpringboardController@index')->name('admin.springboard.index');

Route::get('springboard/create', 'Auth\SpringboardController@create')->name('admin.springboard.create');

Route::post('springboard/create', 'Auth\SpringboardController@store')->name('admin.springboard.store');

Route::get('springboard/{website}', 'Auth\SpringboardController@open')->name('admin.springboard.open');
