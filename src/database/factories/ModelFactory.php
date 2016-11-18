<?php

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$factory->define(Build\Core\Eloquent\Models\Color::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->colorName,
        'color' => $faker->hexColor
    ];
});