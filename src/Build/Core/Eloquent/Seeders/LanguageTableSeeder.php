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

use Build\Core\Eloquent\Models\Language;

class LanguageTableSeeder extends \Illuminate\Database\Seeder
{

    public function run()
    {
        Language::create([
            'name' => 'English',
            'locale' => 'uk-en',
            'is_active' => true,
            'is_main' => true
        ]);
    }
}
