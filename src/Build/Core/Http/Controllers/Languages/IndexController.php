<?php

namespace Build\Core\Http\Controllers\Languages;

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
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Build\Core\Eloquent\Models\Language;
use Build\Core\Http\Entities\LanguageEntity;
use Build\Core\Http\Requests\Language\IndexRequest;

class IndexController extends Controller
{

    /**
     * @return Response
     */
    public function index()
    {
        $this->authorize('index-language');

        if (auth()->user()->can('edit-language')) {
            $q = Language::query();
        } else {
            $q = Language::byWebsite();
        }

        $languages = request('all', 0)
            ? $q->get()
            : $q->where('languages.is_active', 1)->get();

        return entity(LanguageEntity::class, 'index')
            ->setQuery($languages)
            ->render();
    }

    /**
     * @return Response
     */
    public function create()
    {
        $this->authorize('create-language');

        return entity(LanguageEntity::class, 'create')->render();
    }

    /**
     * @param  IndexRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(IndexRequest $request)
    {
        Language::create($request->all());

        alert()->success('Succesfully created a new language.')->flash();

        $this->invalidateCaches();

        return redirect()->route('admin.languages.index');
    }

    /**
     * @param  Language  $language
     *
     * @return Response
     */
    public function edit(Language $language)
    {
        $this->authorize('edit-language');

        return entity(LanguageEntity::class, 'edit')
            ->setQuery($language)
            ->render();
    }

    /**
     * @param  IndexRequest  $request
     * @param  Language  $language
     *
     * @return RedirectResponse
     */
    public function update(IndexRequest $request, Language $language)
    {
        $this->authorize('edit', $language);

        $language->update($request->all());

        alert()->success('Successfully updated the language')->flash();

        $this->invalidateCaches();

        return redirect()->route('admin.languages.index');
    }

    /**
     * @return View
     */
    public function remove()
    {
        $this->authorize('delete-language');

        return view('build.core::screens.languages.remove');
    }

    public function refresh()
    {
        app('cache')->tags('language-labels')->flush();

        alert()->success('Successfully refreshed the languages')->flash();

        return redirect()->back();
    }

    /**
     * @return RedirectResponse
     */
    public function destroy()
    {
        $this->authorize('delete-language');

        Language::destroy(explode(',', request('ids')));

        $this->invalidateCaches();

        return redirect()->back();
    }

    /**
     * Invalidate all language caches.
     */
    protected function invalidateCaches()
    {
        app('cache')->forget('build.languages');
    }
}
