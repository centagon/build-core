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
use Build\Core\Eloquent\Models\Role;
use Build\Core\Eloquent\Models\Website;
use Build\Core\Bauhaus\Widgets\Input\Form;
use Build\Core\Bauhaus\Widgets\Content\Heading;
use Build\Core\Bauhaus\Widgets\Navigation\Button;

/**
 * Class UserEntity
 * @package Build\Auth\Http\Entities
 */
class UserEntity extends Manager
{

    /**
     * Display a listing of the resource.
     *
     * @param  Mapper  $mapper
     */
    public function index($mapper)
    {
        $heading = (new Heading)
            ->title('Users')
            ->add('navigation.button', [
                'to' => route('admin.users.create'),
                'label' => 'Create a new user',
                'style' => Button::STYLE_SUCCESS
            ]);

        $mapper
            ->add($heading)
            ->add('data.table', function ($table) {

                $table->selectable(true);

                $table->add('navigation.link', [
                    'name' => 'name',
                    'label' => 'Full name',
                    'subcolumn' => function ($link) {
                        return $link->getRow()->email;
                    },
                    'to' => function ($link) {
                        return route('admin.users.edit', $link->getRow());
                    }
                ]);

            });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Mapper  $mapper
     */
    public function create($mapper)
    {
        $mapper->add('content.heading', function ($heading) {
            $heading->title('Users');
            $heading->subtitle('Create a new user');
            $heading->add('navigation.button', [
                'label' => 'Cancel',
                'to' => route('admin.users.index')
            ]);
        });

        $mapper->add('input.form', function ($form) {
            $form->action(route('admin.users.store'));

            $form->add('input.text', [
                'name'  => 'name',
                'label' => 'The full name of the user'
            ]);

            $form->add('input.email', [
                'name'  => 'email',
                'label' => 'The users email address'
            ]);

            $form->add('input.divider');

            $form->add('input.password', [
                'name'  => 'password',
                'label' => 'Password'
            ]);

            $form->add('input.password', [
                'name'  => 'password_confirmation',
                'label' => 'Confirm password'
            ]);

            $form->add('input.actions');
        });
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Build\Bauhaus\Mapper\Mapper  $mapper
     */
    public function edit($mapper, $query)
    {
        $heading = (new Heading)
            ->title('Users')
            ->subtitle($query->name)
            ->add('navigation.button', [
                'to' => route('admin.users.index'),
                'label' => 'Cancel'
            ]);

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) use ($query) {

                $form
                    ->action(route('admin.users.update', $query))
                    ->method(Form::METHOD_PUT);

                $form->add('input.text', [
                    'name' => 'name',
                    'label' => 'The full name of the user'
                ]);

                $form->add('input.email', [
                    'name' => 'email',
                    'label' => 'The users email address'
                ]);

                $form->add('input.divider');

                $form->add('input.password', [
                    'name' => 'password',
                    'label' => 'New password'
                ]);

                $form->add('input.password', [
                    'name' => 'password_confirmation',
                    'label' => 'Confirm new password'
                ]);

                $form->add('input.divider');

                $form->add('input.select', [
                    'name' => 'role[0]',
                    'label' => 'Global',
                    'options' => Role::pluck('id', 'id')->toArray(),
                    'selected' => auth()->user()->getRole(null)->id
                ]);

                foreach (Website::all() as $website) {
                    $role = auth()->user()->getRole($website->getKey());

                    if ($role) {
                        $role = $role->getKey();
                    } else {
                        $role = null;
                    }

                    $form->add('input.select', [
                        'name' => "role[{$website->getKey()}]",
                        'label' => $website->name,
                        'options' => Role::pluck('id', 'id')->toArray(),
                        'selected' => $role ?: 9000 // massively hacky
                    ]);
                }

                $form->add('input.actions');

            });
    }
}
