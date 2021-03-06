<?php

namespace Build\Core\Http\Controllers\Async;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\Asset;
use Build\Core\Eloquent\Models\Group;
use Build\Core\Eloquent\Models\Website;
use Build\Core\Http\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class AssetsController extends Controller
{

    /**
     * @return Response
     */
    public function index()
    {
        $rows = [];

        $query = Asset::with([
            'groups'   => function ($q) {
                return $q->select('id', 'name');
            },
            'websites' => function ($q) {
                return $q->select('id');
            },
        ])->get();

        foreach ($query as $asset) {
            $rows[] = $this->format($asset);
        }

        return $rows;
    }

    /**
     *
     * @param integer $asset The Asset
     * @return Response
     */
    public function show(Asset $asset)
    {
        return response()->json($this->format($asset));
    }

    public function update(Request $request, Asset $asset)
    {
        $groups = Arr::pluck($request->get('asset')['groups'], 'id');

        $asset->syncGroups($groups);

        return ['success'];
    }

    public function remove(Asset $asset)
    {
        $asset->delete();
    }

    /**
     * Format the asset
     *
     * @param Asset $asset
     * @return array
     */
    private function format($asset)
    {
        return [
            'id'          => $asset->getKey(),
            'filename'    => $asset->filename,
            'url'         => $asset->url,
            'preview_url' => $asset->preview_url,
            'path'        => $asset->path,
            'size'        => $asset->image_size,
            'filesize'    => [
                'bytes'     => $asset->filesize,
                'formatted' => $asset->formatted_filesize,
            ],
            'groups'      => $asset->groups,
            'websites'    => $asset->websites,
        ];
    }

    public function replace(Request $request, Asset $asset)
    {
        // $assetData = json_decode($request->get('asset'));
        // $asset = Asset::find($assetData->id);

        $file = $request->file('photos')[0];

        $asset->upload($file);
        $asset->generatePreview($file);

        $asset->filename  = $file->getClientOriginalName();
        $asset->filesize  = $file->getClientSize();
        $asset->mimetype  = $file->getClientMimeType();
        $asset->extension = $file->getClientOriginalExtension();

        $asset->save();

        return ['success'];
    }

    /**
     * @return mixed
     */
    public function fetchGroups()
    {
        $key = (new Group)->getCacheKey();

        return Cache::remember($key, config('build.core.cache-ttl'), function () {
            return Group::where('type', Asset::class)
                ->select('id', 'name', 'color')
                ->get();
        });
    }

    public function fetchWebsites()
    {
        return Website::all();
    }
}
