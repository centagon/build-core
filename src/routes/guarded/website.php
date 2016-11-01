<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

Route::get('websites/remove', [
    'as' => 'admin.websites.remove',
    'uses' => 'WebsitesController@remove'
]);

Route::resource('websites', 'WebsitesController');