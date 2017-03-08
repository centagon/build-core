<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::group(['prefix' => 'group-browser'], function () {

    Route::get('/', 'Groups\BrowserController@index')
        ->name('admin.groups.browser.index');

    Route::post('create', 'Groups\BrowserController@store')
        ->name('admin.groups.browser.store');

    Route::get('remove/{group}', 'Groups\BrowserController@remove')
        ->name('admin.groups.browser.delete');

});