<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get('assets/fetch-groups', 'AssetsController@fetchGroups');
Route::get('assets/fetch-websites', 'AssetsController@fetchWebsites');
Route::resource('assets', 'AssetsController');
Route::delete('asset/{asset}', 'AssetsController@remove');
