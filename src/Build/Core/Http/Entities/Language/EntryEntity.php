<?php

namespace Build\Core\Http\Entities\Language;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Bauhaus\Manager;
use Build\Core\Bauhaus\Widgets\Input\Form;
use Build\Core\Bauhaus\Widgets\Content\Heading;
use Build\Core\Eloquent\Models\Language\Dictionary;

class EntryEntity extends Manager
{

    public function index($mapper, $query)
    {
        $language = request()->route('language');

        $heading = (new Heading)->title('Entries')
            ->add('navigation.button', [
                'to' => route('admin.languages.index'),
                'label' => 'Cancel'
            ])
            ->add('navigation.button', [
                'to' => route('admin.languages.entries.create', $language->getKey()),
                'label' => 'Add a new entry',
                'style' => 'button--success'
            ]);

        $mapper
            ->add($heading)
            ->add('data.table', function ($table) {

                $table->selectable(true);

                $table->add('navigation.link', [
                    'label' => 'Dictionary entry',
                    'value' => function ($label) {
                        return $label->getRow()->dictionary->label;
                    },
                    'to' => function ($label) {
                        if (auth()->user()->can('edit-dictionary')) {
                            return route('admin.languages.dictionary.edit', $label->getRow()->dictionary->id);
                        }
                    }
                ]);

                $table->add('navigation.link', [
                    'name' => 'value',
                    'label' => 'Value',
                    'to' => function ($link) {
                        $row = $link->getRow();

                        if (auth()->user()->can('edit-languageentry')) {
                            return route('admin.languages.entries.edit', [$row->language_id, $row->getKey()]);
                        }
                    }
                ]);

            });
    }

    public function create($mapper)
    {
        $heading = (new Heading)
            ->title('Entries')
            ->subtitle('Create a new entry')
            ->add('navigation.button', [
                'to' => route('admin.languages.entries.index', request()->route('language')),
                'label' => 'Cancel',
            ]);

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) {

                $form->action(route('admin.languages.entries.store', request()->route('language')));

                $form->add('input.select', [
                    'name' => 'dictionary_id',
                    'label' => 'Dictionary entry',
                    'options' => Dictionary::pluck('label', 'id')
                ]);

                $form->add('input.textarea', [
                    'name'  => 'value',
                    'label' => 'The translated value'
                ]);

                $form->add('input.actions');
            });
    }

    public function edit($mapper)
    {
        $query = app('build.bauhaus.query');

        $heading = (new Heading)
            ->title('Entries')
            ->subtitle($query->dictionary->label)
            ->add('navigation.button', [
                'label' => 'Cancel',
                'to' => route('admin.languages.entries.index', $query->language->id)
            ]);

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) use ($query) {

                $form->action(route('admin.languages.entries.update', [$query->language_id, $query->id]));
                $form->method(Form::METHOD_PUT);

                $form->add('input.select', [
                    'name' => 'dictionary_id',
                    'label' => 'Dictionary entry',
                    'options' => Dictionary::pluck('label', 'id')
                ]);

                $form->add('input.textarea', [
                    'name' => 'value',
                    'label' => 'The translated value'
                ]);

                $form->add('input.actions');
            });
    }
}