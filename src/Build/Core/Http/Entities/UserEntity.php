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
use Build\Core\Bauhaus\Widgets\Form;
use Build\Core\Bauhaus\Mapper\Mapper;
use Build\Core\Bauhaus\Widgets\Button;

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
        $mapper->add('heading', function ($heading) {
            $heading->title('Users');

            $heading->add('button', [
                'label' => 'Create a new user',
                'style' => Button::STYLE_SUCCESS,
                'to' => route('admin.users.create')
            ]);
        });

        $mapper->add('table', function ($table) {
            $table->selectable(true);

            $table->add('link', [
                'name'  => 'name',
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
        $mapper->add('heading', function ($heading) {
            $heading->title('Users');
            $heading->subtitle('Create a new user');
            $heading->add('button', [
                'label' => 'Cancel',
                'to' => route('admin.users.index')
            ]);
        });

        $mapper->add('form', function ($form) {
            $form->action(route('admin.users.store'));

            $form->add('input.text', [
                'name'  => 'name',
                'label' => 'The full name of the user'
            ]);

            $form->add('input.email', [
                'name'  => 'email',
                'label' => 'The users email address'
            ]);

            $form->add('divider');

            $form->add('input.password', [
                'name'  => 'password',
                'label' => 'Password'
            ]);

            $form->add('input.password',[
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
    public function edit($mapper)
    {
        $query = app('build.bauhaus.query');

        $mapper->add('heading', function ($heading) use ($query) {
            $heading->title('Users');
            $heading->subtitle($query->name);
            $heading->add('button', [
                'label' => 'Cancel',
                'to' => route('admin.users.index')
            ]);
        });

        $mapper->add('form', function ($form) use ($query) {
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

            $form->add('divider');

            $form->add('input.password', [
                'name' => 'password',
                'label' => 'New password'
            ]);

            $form->add('input.password',[
                'name' => 'password_confirmation',
                'label' => 'Confirm new password'
            ]);

            $form->add('partial', [
                'name' => 'build.core::screens.users.partials.opensidebar',
                'data' => ['query' => $query]
            ]);
            
            $form->add('input.actions');
        })->add('partial', [
            'name' => 'build.core::screens.users.partials.sidebar',
        ]);
    }
}