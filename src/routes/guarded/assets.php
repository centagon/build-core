<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::resource('assets', 'AssetsController');

Route::group(['prefix' => 'asset-browser'], function () {

    Route::get('files', 'Assets\BrowserController@files')
        ->name('admin.assets.browser.files');

    Route::get('create', 'Assets\BrowserController@create')
        ->name('admin.assets.browser.create');

    Route::post('create', 'Assets\BrowserController@store')
        ->name('admin.assets.browser.store');

});