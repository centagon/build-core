<?php

namespace Build\Core\Http\Controllers\Groups;

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
use Build\Core\Eloquent\Models\Group;

class BrowserController extends Controller
{

    /**
     * @param  Request $request
     *
     * @return View
     */
    public function index(Request $request)
    {
        $this->validate($request, ['type' => 'required']);

        $groups = Group::byType($request->get('type'))->get();

        return view('build.core::screens.groups.browser.index')->with(compact('groups'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'name' => 'required',
            'color' => 'required'
        ]);

        Group::create($request->all());

        return redirect()->back();
    }

    public function remove(Group $group)
    {
        $group->delete();

        return redirect()->back();
    }
}