<?php

namespace Build\Core\Http\Entities;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Bauhaus\Manager;
use Build\Core\Bauhaus\Widgets\Content\Heading;
use Build\Core\Bauhaus\Widgets\Input\Form;

class LanguageEntity extends Manager
{

    public function index($mapper)
    {
        $heading = (new Heading)->title('Languages');

        if (auth()->user()->can('create-language')) {
            $heading->add('navigation.button', [
                'to' => route('admin.languages.dictionary.index'),
                'label' => 'Dictionary'
            ]);

            $heading->add('navigation.button', [
                'to' => route('admin.languages.create'),
                'label' => 'Create a new language',
                'style' => 'button--success'
            ]);
        }

        $mapper
            ->add($heading)
            ->add('data.table', function ($table) {
                $table->selectable('true');

                $table->add('navigation.link', [
                    'name' => 'name',
                    'label' => 'Language',
                    'to' => function ($link) {
                        if (auth()->user()->can('edit-language', $link->getRow())) {
                            return route('admin.languages.edit', $link->getRow());
                        }
                    },
                    'subcolumn' => function ($link) {
                        return $link->getRow()->locale;
                    }
                ]);

                $table->add('content.icon', [
                    'label' => 'Is active?',
                    'icon'  => function ($icon) {
                        return $icon->getRow()->is_active ? 'check' : '';
                    }
                ]);

                if (auth()->user()->can('edit-languageentry')) {
                    $table->add('navigation.button', [
                        'align' => 'right',
                        'label' => 'Entries',
                        'hidden' => true,
                        'to' => function ($button) {
                            return route('admin.languages.entries.index', $button->getRow());
                        }
                    ]);
                }
            });
    }

    public function edit($mapper, $query)
    {
        $heading = (new Heading)
            ->title('Languages')
            ->subtitle($query->name)
            ->add('navigation.button', [
                'to' => route('admin.languages.index'),
                'label' => 'Back to overview'
            ]);

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) use ($query) {

                $form
                    ->action(route('admin.languages.update', $query))
                    ->method(Form::METHOD_PUT);

                $form
                    ->add('input.text', [
                        'name' => 'name',
                        'label' => 'The name of the language'
                    ])
                    ->add('input.text', [
                        'name' => 'locale',
                        'label' => 'The language locale'
                    ])
                    ->add('input.checkbox', [
                        'name' => 'is_active',
                        'label' => 'Is this language active?'
                    ])
                    ->add('input.checkbox', [
                        'name' => 'is_main',
                        'label' => 'Is this the main language?'
                    ]);

                $form->add('input.actions');

            });
    }

    public function create($mapper)
    {
        $heading = (new Heading) ->title('Languages')->add('navigation.button', [
            'to' => route('admin.languages.index'),
            'label' => 'Back to overview'
        ]);

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) {

                $form->action(route('admin.languages.store'));

                $form
                    ->add('input.text', [
                        'name' => 'name',
                        'label' => 'The name of the language',
                        'placeholder' => 'English'
                    ])
                    ->add('input.text', [
                        'name' => 'locale',
                        'label' => 'The language locale',
                        'placeholder' => 'uk-en'
                    ])
                    ->add('input.checkbox', [
                        'name' => 'is_active',
                        'label' => 'Is this language active?',
                        'default' => true
                    ])
                    ->add('input.checkbox', [
                        'name' => 'is_main',
                        'label' => 'Is this the main language?'
                    ]);

                $form->add('input.actions');

            });
    }
}