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

use Illuminate\View\View;
use Illuminate\Http\Request;
use Build\Core\Http\Controller;
use Illuminate\Http\RedirectResponse;
use Build\Core\Eloquent\Models\Color;
use Build\Core\Support\Facades\Discovery;
use Build\Core\Eloquent\Models\DashboardBlock;

class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $blocks = DashboardBlock::byWebsite()->get();

        return view('build.core::screens.dashboard')->with([
            'blocks' => $blocks,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $colors = Color::all();

        return view('build.core::screens.dashboard.create')->with([
            'colors' => $colors,
        ]);
    }

    /**
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $lastBlock = DashboardBlock::byWebsite()
            ->orderBy('y', 'desc')
            ->first();

        $y = $lastBlock ? ($lastBlock->y + $lastBlock->height) : 0;

        $block = new DashboardBlock($request->all() + [
            'y' => $y,
            'width' => 12,
            'height' => 5,
        ]);

        $block->website()->associate(Discovery::backendWebsite());
        $block->save();

        return redirect()->back();
    }

    /**
     * @param  DashboardBlock  $block
     * @return View
     */
    public function edit(DashboardBlock $block): View
    {
        $colors = Color::all();

        return view('build.core::screens.dashboard.edit')->with([
            'block' => $block,
            'colors' => $colors,
        ]);
    }

    /**
     * @param  Request  $request
     * @param  DashboardBlock  $block
     * @return RedirectResponse
     */
    public function update(Request $request, DashboardBlock $block): RedirectResponse
    {
        $block->update($request->all());

        return redirect()->back();
    }

    /**
     * @param  DashboardBlock  $block
     * @return RedirectResponse
     */
    public function remove(DashboardBlock $block): RedirectResponse
    {
        $block->delete();

        return redirect()->back();
    }

    /**
     * @param  Request  $request
     * @return array
     */
    public function updateNodes(Request $request): array
    {
        $nodes = $request->get('nodes');

        foreach ($nodes as $node) {
            $block = DashboardBlock::find($node['id']);
            $block->update($node);
        }

        return ['ok'];
    }
}
