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
use Build\Core\Eloquent\Models\Asset;

class AssetEntity extends Manager
{

    public function create($mapper)
    {
        $mapper->add('input.form', function ($form) {

            $form->action(route('admin.assets.store'));
            $form->files(true);

            $form->add('content.heading', function ($heading) {

                $heading
                    ->title('New File')
                    ->add('navigation.button', [
                        'to' => route('admin.assets.index'),
                        'label' => 'Cancel'
                    ])->add('input.submit');
            });

            $form->add('input.file', [
                'name' => 'file',
                'label' => 'Upload a new file'
            ]);

            $form->add('input.groups', [
                'name' => 'groups',
                'model' => Asset::class,
                'label' => 'Asset groups'
            ]);

        });
    }

    public function browserCreate($mapper)
    {
        $this->view = 'build.core::screens.bauhaus.no-nav';

        $mapper->add('input.form', function ($form) {

            $form->action(route('admin.assets.browser.store'));
            $form->files(true);

            $form->add('content.heading', function ($heading) {

                $heading
                    ->title('New File')
                    ->add('navigation.button', [
                        'to' => route('admin.assets.browser.files'),
                        'label' => 'Cancel'
                    ])->add('input.submit');
            });

            $form->add('input.file', [
                'name' => 'file',
                'label' => 'Upload a new file'
            ]);

            $form->add('input.groups', [
                'name' => 'groups',
                'model' => Asset::class,
                'label' => 'Asset groups'
            ]);

        });
    }
}