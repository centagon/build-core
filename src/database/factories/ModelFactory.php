<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\Color;
use Build\Core\Eloquent\Models\Website;
use Build\Core\Eloquent\Models\Language;

$factory->define(Color::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->colorName,
        'color' => $faker->hexColor
    ];
});

$factory->define(Website::class, function (Faker\Generator $faker) {
    return [
        'language_id' => factory(Language::class)->create()->getKey(),
        'name' => $faker->domainName,
        'domain' => 'https://' . $faker->domainName,
        'is_active' => $faker->boolean
    ];
});

$factory->define(Language::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->countryCode,
        'locale' => $faker->locale,
        'is_active' => $faker->boolean,
        'is_main' => $faker->boolean
    ];
});