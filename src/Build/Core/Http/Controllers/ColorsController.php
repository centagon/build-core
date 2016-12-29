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
use Build\Core\Support\Facades\Asset;
use Illuminate\Support\Facades\Cache;
use Build\Core\Eloquent\Models\Color;
use Illuminate\Http\RedirectResponse;
use Build\Core\Http\Entities\ColorEntity;
use Build\Core\Http\Requests\ColorRequest;

class ColorsController extends Controller
{

    /**
     * @return Response
     */
    public function index()
    {
        $this->authorize('index-color');

        $colors = Color::all();

        return view('build.core::screens.colors.index')->with(compact('colors'));
    }

    /**
     * @return Response
     */
    public function create()
    {
        $this->authorize('create-color');

        return entity(ColorEntity::class, 'create')->render();
    }

    /**
     * @param  ColorRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(ColorRequest $request)
    {
        Color::create($request->all());

        $this->invalidateCaches();

        alert()->success('Successfully create a new color')->flash();

        return redirect()->route('admin.colors.index');
    }

    /**
     * @param  Color  $color
     *
     * @return Response
     */
    public function edit(Color $color)
    {
        $this->authorize('edit-color');

        return entity(ColorEntity::class, 'edit')->setQuery($color)->render();
    }

    /**
     * @param  ColorRequest  $request
     * @param  Color  $color
     *
     * @return RedirectResponse
     */
    public function update(ColorRequest $request, Color $color)
    {
        $this->authorize('edit-color');

        $color->update($request->all());

        $this->invalidateCaches();

        alert()->success('Successfully updated a color')->flash();

        return redirect()->route('admin.colors.index');
    }

    public function render()
    {
        $styles = [];

        $colors = Cache::rememberForever('build.colors.all', function () {
            return Color::all();
        });

        foreach ($colors as $color) {
            $styles[] = '.background-' . $color->name . '{background-color:' . $color->color . ';}';
            $styles[] = '.foreground-' . $color->name . '{color:' . $color->color . ';}';
        }

        $response = implode('', $styles);

        return response($response, 304, [
            'Content-Type' => 'text/css'
        ]);
    }

    /**
     * Invalidate all color caches.
     */
    protected function invalidateCaches()
    {
        // Forget the 'master' cache
        app('cache')->forget('build.colors.all');

        // Forget the individual color caches.
        foreach (Color::all() as $color) {
            app('cache')->forget('build.colors.' . $color->getKey());
        }
    }
}
