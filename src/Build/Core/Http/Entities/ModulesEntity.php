<?php

namespace Build\Core\Http\Entities;

use Build\Core\Bauhaus\Manager;
use Build\Core\Bauhaus\Widgets\Content\Heading;
use Build\Core\Bauhaus\Widgets\Input\Form;

class ModulesEntity extends Manager
{

    public function index($mapper)
    {
        $heading = (new Heading)->title('Modules');

        $mapper->add($heading);

        $mapper->add('data.table', function ($table) {
            $table->selectable(true);

            $table->add('navigation.link', [
                'name'  => 'name',
                'label' => 'Full name',
                'subcolumn' => function ($link) {
                    return $link->getRow()->slug;
                },
                'to' => function ($link) {
                    return route('admin.modules.edit', $link->getRow()->slug);
                }
            ]);
        });
    }

    public function edit($mapper, $query)
    {
        $heading = (new Heading)
            ->title('Modules')
            ->subtitle($query['name'])
            ->add('navigation.button', [
                'to' => route('admin.modules.index'),
                'label' => 'Cancel'
            ]);

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) use ($query) {

                $form
                    ->action(route('admin.modules.update', $query['slug']))
                    ->method(Form::METHOD_PUT);

                foreach ($query as $key => $value) {
                    if ($key == 'enabled') {
                        $form->add('input.checkbox', [
                            'name' => 'enabled',
                            'label' => 'Is this module enabled?'
                        ]);

                        continue;
                    }

                    $form->add('input.text', [
                        'name' => $key,
                        'label' => $key
                    ]);
                }

                $form->add('input.actions');

            });
    }
}