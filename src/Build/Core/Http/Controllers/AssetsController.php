<?php

namespace Build\Core\Http\Controllers;

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

class AssetsController extends Controller
{

    /**
     * @return Response
     */
    public function index()
    {
        return view('build.core::screens.assets.index');
    }

    public function create()
    {
        return entity(AssetEntity::class, 'create')->render();
    }

    public function store(AssetRequest $request)
    {
        $file = $request->file('file');

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

        return redirect()->route('admin.assets.index');
    }
}