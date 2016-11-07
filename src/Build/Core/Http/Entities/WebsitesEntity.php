<?php

namespace Build\Core\Http\Entities;

/**
 * This file is part of the Centagon Build/Core package.
 *
 * (c) Centagon <build@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Bauhaus\Mapper;
use Build\Core\Bauhaus\Manager;
use Build\Core\Eloquent\Models\Language;
use Build\Core\Bauhaus\Widgets\Input\Form;
use Build\Core\Bauhaus\Widgets\Content\Heading;
use Build\Core\Bauhaus\Widgets\Navigation\Button;

class WebsitesEntity extends Manager
{

    public function index(Mapper $mapper)
    {
        $heading = (new Heading)->title('Websites');
        
        $heading->add('navigation.button', function ($button) {
            $button
                ->permission('create-website')
                ->label('New website')
                ->style(Button::STYLE_SUCCESS)
                ->to(route('admin.websites.create'));
        });

        $mapper->add($heading);

        $mapper->add('data.table', function ($table) {
//            if (request()->user()->can('delete-website')) {
                $table->selectable(true);
//                $table->routes([
//                    'remove' => route('admin.websites.remove'),
//                    'destroy' => route('admin.websites.destroy', 0)
//                ]);
//            }
//
//            $table->add('box.websitecolor', function ($color) {
//                $color->name('color');
//                $color->label('');
//                $color->websitecolorbox(function ($color) {
//                    return $color->getRow()->color;
//                });
//            });
//
            $table->add('navigation.link', function ($link) {
                $link
                    ->name('name')
                    ->label('Domain');

                $link->to(function ($link) {
                    if (auth()->user()->can('edit-website')) {
                        return route('admin.websites.edit', $link->getRow()->id);
                    }
                });

                $link->subcolumn(function ($link) {
                    return $link->getRow()->domain;
                });
            });

            $table->add('content.icon', function ($icon) {
                $icon
                    ->name('is_activated')
                    ->label('Is activated?')
                    ->icon(function ($icon) {
                        return $icon->getRow()->is_active ? 'check' : '';
                    });
            });
        });
    }

    public function create(Mapper $mapper)
    {
        $heading = (new Heading)
            ->title('Websites')
            ->subtitle('Create a new website')
            ->add('navigation.button', function ($button) {
                $button
                    ->label('Cancel')
                    ->style(Button::STYLE_SECONDARY)
                    ->to(route('admin.websites.index'));
            });

        $mapper
            ->add($heading)
            ->add('input.form', function ($form) {

                $form->action(route('admin.websites.store'));

                $form->add('input.text', [
                    'name' => 'name',
                    'label' => 'The name of the website',
                    'placeholder' => 'My awesome website'
                ]);

                $form->add('input.text', [
                    'name' => 'domain',
                    'label' => 'This website resolves to',
                    'placeholder' => 'https://my-domain.com'
                ]);

                $form->add('input.color', [
                    'name' => 'color',
                    'label' => 'The color of the website'
                ]);

                $form->add('input.select', [
                    'name' => 'language_id',
                    'label' => 'The language',
                    'options' => Language::pluck('name', 'id')
                ]);

                if (request()->user()->can('activate-website')) {
                    $form->add('input.checkbox', function ($checkbox) {
                        $checkbox->name('is_active');
                        $checkbox->label('Is this website active?');
                    });
                }

                $form->add('input.actions');
            });
    }

    public function edit(Mapper $mapper, $query)
    {
        $heading = (new Heading)
            ->title('Websites')
            ->subtitle($query->name)
            ->add(Button::class, function ($button) {
                $button->label('Cancel');
                $button->style(Button::STYLE_SECONDARY);
                $button->to(route('admin.websites.index'));
            });

        $mapper->add($heading);

        $mapper->add('input.form', function ($form) use ($query) {
            $form
                ->action(route('admin.websites.update', $query->getKey()))
                ->method(Form::METHOD_PUT);

            $form->add('input.text', [
                'name' => 'name',
                'label' => 'The name of the website',
                'placeholder' => 'My awesome website'
            ]);

            $form->add('input.text', [
                'name' => 'domain',
                'label' => 'This website resolves to',
                'placeholder' => 'https://my-domain.com'
            ]);

            $form->add('input.color', [
                'name' => 'color',
                'label' => 'The color of the website'
            ]);

            $form->add('input.select', [
                'name' => 'language_id',
                'label' => 'The language',
                'options' => Language::pluck('name', 'id')
            ]);

            if (request()->user()->can('activate-website')) {
                $form->add('input.checkbox', function ($checkbox) {
                    $checkbox->name('is_active');
                    $checkbox->label('Is this website active?');
                });
            }

            $form->add('input.actions');
        });
    }
}