<?php

namespace Build\Core\Http\Controllers\Assets;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Response;
use Build\Core\Http\Controller;
use Build\Core\Eloquent\Models\Asset;
use Build\Core\Support\Facades\Discovery;
use Build\Core\Http\Entities\AssetEntity;
use Build\Core\Http\Requests\AssetRequest;

class BrowserController extends Controller
{

    public function files()
    {
        $assets = Asset::all();

        return view('build.core::screens.assets.browser.files')->with([
            'assets' => $assets
        ]);
    }
}