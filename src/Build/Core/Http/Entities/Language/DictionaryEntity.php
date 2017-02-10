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
use Build\Core\Bauhaus\Widgets\Navigation\Button;

class DictionaryEntity extends Manager
{

    public function index($mapper)
    {
        $heading = (new Heading)->title('Language dictionary')
            ->add('navigation.button', [
                'to' => route('admin.languages.index'),
                'label' => 'Cancel'
            ])
            ->add('navigation.button', [
                'to' => route('admin.languages.dictionary.create'),
                'label' => 'Add a new dictionary entry',
                'style' => Button::STYLE_SUCCESS
            ]);

        $mapper
            ->add($heading)
            ->add('data.table', function ($table) {
                $table->selectable(true);

                $table->add('navigation.link', [
                    'name' => 'label',
                    'label' => 'Dictionary entry',
                    'to' => function ($link) {
                        if (request()->user()->can('edit-dictionary')) {
                            return build_route('languages.dictionary.edit', $link->getRow()->getKey());
                        }
                    }
                ]);

                $table->add('content.text', [
                    'name' => 'description',
                    'label' => 'Description',
                    'value' => function ($table) {
                        return str_limit($table->getRow()->description, 75);
                    }
                ]);
            });
    }

    public function create($mapper)
    {
        $heading = (new Heading)->title('Language dictionary')
            ->subtitle('Create a new entry')
            ->add('navigation.button', [
                'to' => route('admin.languages.dictionary.index'),
                'label' => 'Cancel'
            ]);

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) {

                $form->action(route('admin.languages.dictionary.store'));

                $form
                    ->add('input.text', [
                        'name' => 'label',
                        'label' => 'The name of the entry'
                    ])->add('input.textarea', [
                        'name' => 'description',
                        'label' => 'Describe the entry'
                    ])->add('input.actions');
            });
    }

    public function edit($mapper, $query)
    {
        $heading = (new Heading)->title('Language dictionary')
            ->subtitle('Create a new entry')
            ->add('navigation.button', [
                'to' => route('admin.languages.dictionary.index'),
                'label' => 'Cancel'
            ]);

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) use ($query) {

                $form
                    ->action(route('admin.languages.dictionary.update', $query))
                    ->method(Form::METHOD_PUT);

                $form
                    ->add('input.text', [
                        'name' => 'label',
                        'label' => 'The name of the entry'
                    ])->add('input.textarea', [
                        'name' => 'description',
                        'label' => 'Describe the entry'
                    ])->add('input.actions');
            });
    }
}
