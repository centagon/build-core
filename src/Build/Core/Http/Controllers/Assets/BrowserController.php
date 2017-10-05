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

use Build\Core\Http\Controller;
use Build\Core\Eloquent\Models\Asset;
use Build\Core\Http\Entities\AssetEntity;
use Build\Core\Http\Requests\AssetRequest;
use Build\Core\Support\Facades\Discovery;

class BrowserController extends Controller
{

    public function files()
    {
        $assets = Asset::all();

        return view('build.core::screens.assets.browser.files')->with([
            'assets' => $assets
        ]);
    }

    public function create()
    {
        return entity(AssetEntity::class, 'browserCreate')->render();
    }

    public function store(AssetRequest $request)
    {
        $file = $request->file('file');

        if(substr($file->getMimeType(), 0, 5) == 'image') {
            $this->validate($request, [
                'file' => 'max:'.config('build.core.max-image-size'),
            ]);
        }

        $asset = new Asset([
            'filename' => $file->getClientOriginalName(),
            'filesize' => $file->getClientSize(),
            'mimetype' => $file->getClientMimeType(),
            'extension' => $file->getClientOriginalExtension(),
        ]);

        $asset->save();

        $asset->websites()->save(Discovery::backendWebsite());

        $asset->syncGroups($request->get('groups', []));

        $asset->upload($file);
        $asset->generatePreview($file);

        return redirect()->route('admin.assets.browser.files');
    }
}