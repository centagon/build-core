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
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Build\Core\Eloquent\Models\Website;
use Build\Core\Eloquent\Models\Language;
use Build\Core\Http\Entities\WebsitesEntity;
use Build\Core\Http\Requests\WebsiteRequest;

class WebsitesController extends \Build\Core\Http\Controller
{

    /**
     * @return View
     */
    public function index()
    {
        $this->authorize('index-website');

        $websites = Website::all();

        return view('build.core::screens.websites.index')->with([
            'websites' => $websites
        ]);
    }

    /**
     * @return Response
     */
    public function create()
    {
        $this->authorize('create-website');

        return entity(WebsitesEntity::class, 'create')->render();
    }

    /**
     * @param  WebsiteRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(WebsiteRequest $request)
    {
        $this->authorize('create-website');

        $language = Language::findOrFail($request->get('language_id'));

        $website = new Website($request->all());
        $website->language()->associate($language);
        $website->save();

        alert()->success('Successfully created a website.')->flash();

        return redirect()->route('admin.websites.index');
    }

    /**
     * @param  Website  $website
     *
     * @return Response
     */
    public function edit(Website $website)
    {
        $this->authorize('edit-website');

        return entity(WebsitesEntity::class, 'edit')
            ->setQuery($website)
            ->render();
    }

    /**
     * @param  WebsiteRequest  $request
     * @param  Website         $website
     *
     * @return RedirectResponse
     */
    public function update(WebsiteRequest $request, Website $website)
    {
        $this->authorize('edit-website');

        $language = Language::findOrFail($request->get('language_id'));

        $website->update($request->all());
        $website->language()->associate($language);
        $website->save();

        alert()->success('Successfully updated a website.')->flash();

        return redirect()->route('admin.websites.index');
    }

    /**
     * @return View
     */
    public function remove()
    {
        $this->authorize('delete-website');

        return view('build.core::screens.websites.remove');
    }

    /**
     * @return RedirectResponse
     */
    public function destroy()
    {
        $this->authorize('delete-website');

        Website::destroy(explode(',', request('ids')));

        return redirect()->back();
    }
}
