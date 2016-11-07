<?php

namespace Build\Core\Eloquent\Seeders;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\Website;
use Build\Core\Eloquent\Models\Language;

class WebsiteTableSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        $website = new Website([
            'name' => 'Localhost',
            'domain' => 'localhost',
            'is_active' => true
        ]);

        $website->language()->associate(Language::first());
        $website->save();
    }
}