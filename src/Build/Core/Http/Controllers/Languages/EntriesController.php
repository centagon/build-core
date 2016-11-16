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
use Build\Core\Eloquent\Models\Language;
use Build\Core\Eloquent\Models\Language\Entry;
use Build\Core\Http\Entities\Language\EntryEntity;
use Build\Core\Http\Requests\Language\EntryRequest;

class EntriesController extends Controller
{

    /**
     * @param  Language  $language
     *
     * @return Response
     */
    public function index(Language $language)
    {
        $this->authorize('index-languageentry');

        $entries = $language->entries;

        return entity(EntryEntity::class, 'index')->setQuery($entries)->render();
    }

    /**
     * @return Response
     */
    public function create()
    {
        $this->authorize('create-languageentry');

        return entity(EntryEntity::class, 'create')->render();
    }

    /**
     * @param  EntryRequest  $request
     * @param  Language      $language
     *
     * @return RedirectResponse
     */
    public function store(EntryRequest $request, Language $language)
    {
        $this->authorize('create-languageentry');

        $dictionary = Language\Dictionary::findOrFail($request->get('dictionary_id'));

        $entry = new Entry($request->all() + [
            'locale' => $language->locale,
            'entry' => $dictionary->label
        ]);

        $entry->language()->associate($language);
        $entry->dictionary()->associate($dictionary);
        $entry->save();

        alert()->success('Successfully created a new entry.')->flash();

        return redirect()->route('admin.languages.entries.index', $language);
    }

    public function edit(Language $language, Entry $entry)
    {
        $this->authorize('edit-languageentry');

        return entity(EntryEntity::class, 'edit')
            ->setQuery($entry)
            ->render();
    }

    public function update(EntryRequest $request, Language $language, Entry $entry)
    {
        $this->authorize('edit-languageentry');

        $entry->update($request->all() + [
            'locale' => $language->locale,
            'entry'  => $entry->dictionary->label
        ]);
        $entry->language()->associate($language);
        $entry->dictionary()->associate($request->get('dictionary_id'));
        $entry->save();

        alert()->success('Successfully updated an entry.')->flash();

        return redirect()->route('admin.languages.entries.index', $language);
    }
}
