<?php

namespace Build\Core\Providers;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\Color;
use Build\Core\Support\Facades\Asset;
use Illuminate\Support\Facades\Cache;

class ColorServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Boot the provider.
     */
    public function boot()
    {
        if ( ! app()->runningInConsole()) {
            $this->renderInlineStyles();
        }
    }

    protected function renderInlineStyles()
    {
        $styles = [];

        $colors = Cache::rememberForever('build.colors.all', function () {
            return Color::all();
        });

        foreach ($colors as $color) {
            $styles[] = '.background-' . $color->name . '{background-color:' . $color->color . ';}';
            $styles[] = '.foreground-' . $color->name . '{color:' . $color->color . ';}';
        }

        Asset::inlineStyle(implode('', $styles));
    }
}
