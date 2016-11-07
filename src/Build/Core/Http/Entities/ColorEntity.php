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

class ColorEntity extends Manager
{

    public function create($mapper, $query)
    {
        $heading = (new Heading)
            ->title('Colors')
            ->subtitle('Add a new color');

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) {

                $form->action(route('admin.colors.store'));

                $form->add('input.text', [
                    'name' => 'name',
                    'label' => 'The name of the color'
                ]);

                $form->add('input.color', [
                    'name' => 'color',
                    'label' => 'The color value'
                ]);

                $form->add('input.actions');

            });
    }

    public function edit($mapper, $query)
    {
        $heading = (new Heading)
            ->title('Colors')
            ->subtitle($query->name)
            ->add('navigation.button', [
                'to' => route('admin.colors.index'),
                'label' => 'To overview'
            ]);

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) use ($query) {

                $form
                    ->action(route('admin.colors.update', $query))
                    ->method('PUT');

                $form->add('input.text', [
                    'name' => 'name',
                    'label' => 'The name of the color'
                ]);

                $form->add('input.color', [
                    'name' => 'color',
                    'label' => 'The color value'
                ]);

                $form->add('input.actions');
            });
    }
}