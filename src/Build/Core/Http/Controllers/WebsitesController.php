<?php

namespace Build\Core\Http\Controllers;

use Build\Core\Http\Controller;
use Build\Core\Eloquent\Models\Website;
use Build\Core\Http\Entities\WebsitesEntity;
use Build\Core\Http\Requests\WebsiteRequest;
use Build\Core\Contracts\Repositories\Website as Repository;

class WebsitesController extends Controller
{
    /**
     * @var \Build\Core\Contracts\Repositories\Website
     */
    protected $website;

    /**
     * Create a new websites controller instance.
     *
     * @param  \Build\Core\Contracts\Repositories\Website  $website
     * @return void
     */
    public function __construct(Repository $website)
    {
        $this->website = $website;
    }

    /**
     * Show a list of websites.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $this->authorize('index-website');

        return view('build.core::screens.websites.index', [
            'websites' => $this->website->getAllWebsites(),
        ]);
    }

    /**
     * Show the create website form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create-website');

        return entity(WebsitesEntity::class, 'create')->render();
    }

    /**
     * Show the edit website form.
     *
     * @param  \Build\Core\Eloquent\Models\Website  $website
     * @return \Illuminate\View\View
     */
    public function edit(Website $website)
    {
        $this->authorize('edit-website');

        return entity(WebsitesEntity::class, 'edit')
            ->setQuery($website)
            ->render();
    }

    /**
     * Update the given website.
     *
     * @param  \Build\Core\Http\Requests\WebsiteRequest  $request
     * @param  \Build\Core\Eloquent\Models\Website  $website
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(WebsiteRequest $request, Website $website)
    {
        $this->authorize('edit-website');

        $this->website->updateWebsite($website, $request->all());

        alert()->success('Successfully updated a website.')->flash();

        return redirect()->route('admin.websites.index');
    }

    /**
     * Show the website remove form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function remove()
    {
        $this->authorize('delete-website');

        return view('build.core::screens.websites.remove');
    }

    /**
     * Destroy the given website.
     *
     * @param  \Build\Core\Eloquent\Models\Website  $website
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($website)
    {
        $this->authorize('delete-website');

        $website->delete();

        return redirect()->route('admin.websites.index');
    }
}
