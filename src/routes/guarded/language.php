<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get('languages/remove', [
    'as' => 'admin.languages.remove',
    'uses' => 'Languages\IndexController@remove'
]);

Route::resource('languages', 'Languages\IndexController', [
    'except' => ['show']
]);

Route::get('languages/refresh', [
    'as' => 'admin.languages.refresh',
    'uses' => 'Languages\IndexController@refresh',
]);

Route::resource('languages.entries', 'Languages\EntriesController');
Route::resource('languages/dictionary', 'Languages\DictionaryController');
