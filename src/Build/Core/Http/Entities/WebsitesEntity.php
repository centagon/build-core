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
use Build\Core\Bauhaus\Widgets\Data\ActionButton;
use Build\Core\Eloquent\Models\Language;
use Build\Core\Bauhaus\Widgets\Input\Form;
use Build\Core\Bauhaus\Widgets\Content\Heading;
use Build\Core\Bauhaus\Widgets\Navigation\Button;

class WebsitesEntity extends Manager
{
    public function index(Mapper $mapper)
    {
        $heading = (new Heading)->title('Websites');
        $heading->add('navigation.button', [
            'label' => 'Create new website',
            'style' => Button::STYLE_SUCCESS,
            'to' => route('admin.websites.create'),
        ]);

        $mapper->add($heading);
        $mapper->add('data.table', function ($table) {
            $table->selectable(true);

            $table->add('navigation.link', [
                'name' => 'name',
                'label' => 'Domain',
                'subcolumn' => function ($link) {
                    return $link->getRow()->domain;
                }
            ]);

            $table->add('content.icon', [
                'label' => 'Is activated?',
                'icon' => function ($icon) {
                    return $icon->getRow()->is_active ? 'check' : '';
                }
            ]);

            $table->add('navigation.button', [
                'align' => 'right',
                'label' => 'Properties',
                'hidden' => true,
                'to' => function ($button) {
                    return route('admin.websites.edit', $button->getRow());
                }
            ]);

            $table->actions([
                (new ActionButton)->set([
                    'label' => 'Remove selection',
                    'style' => Button::STYLE_ALERT,
                    'view' => route('admin.websites.remove', 0),
                    'confirm' => route('admin.websites.remove', 0)
                ])
            ]);
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
