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
use Illuminate\Http\RedirectResponse;
use Build\Core\Eloquent\Models\Language\Dictionary;
use Build\Core\Http\Entities\Language\DictionaryEntity;
use Build\Core\Http\Requests\Language\DictionaryRequest;

class DictionaryController extends Controller
{

    /**
     * @return Response
     */
    public function index()
    {
        $this->authorize('index-dictionary');

        $entries = Dictionary::all();

        return entity(DictionaryEntity::class, 'index')
            ->setQuery($entries)
            ->render();
    }

    /**
     * @return Response
     */
    public function create()
    {
        $this->authorize('create-dictionary');

        return entity(DictionaryEntity::class, 'create')->render();
    }

    /**
     * @param  DictionaryRequest  $request
     *
     * @return RedirectResponse
     */
    public function store(DictionaryRequest $request)
    {
        $this->authorize('create-dictionary');

        Dictionary::create($request->all());

        alert()->success('Successfully create a new entry.')->flash();

        return redirect()->route('admin.languages.dictionary.index');
    }

    /**
     * @param  Dictionary  $dictionary
     *
     * @return Response
     */
    public function edit(Dictionary $dictionary)
    {
        $this->authorize('edit-dictionary');

        return entity(DictionaryEntity::class, 'edit')
            ->setQuery($dictionary)
            ->render();
    }

    /**
     * @param  DictionaryRequest  $request
     * @param  Dictionary         $dictionary
     *
     * @return RedirectResponse
     */
    public function update(DictionaryRequest $request, Dictionary $dictionary)
    {
        $this->authorize('edit-dictionary');

        $dictionary->update($request->all());

        alert()->success('Successfully updated the entry.')->flash();

        return redirect()->route('admin.languages.dictionary.index');
    }
}
