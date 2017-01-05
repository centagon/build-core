<?php

namespace Build\Core\Providers;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Bauhaus\Widgets;
use Build\Core\Bauhaus\Support\Registrar;

class BauhausServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * @var array
     */
    protected $dataWidgets = [
        'data.table' => Widgets\Data\Table::class,
    ];

    /**
     * @var array
     */
    protected $inputWidgets = [
        'input.date' => Widgets\Input\Date::class,
        'input.file' => Widgets\Input\File::class,
        'input.form' => Widgets\Input\Form::class,
        'input.tags' => Widgets\Input\Tags::class,
        'input.text' => Widgets\Input\Text::class,
        'input.date' => Widgets\Input\Date::class,
        'input.datetime' => Widgets\Input\DateTime::class,
        'input.email' => Widgets\Input\Email::class,
        'input.color' => Widgets\Input\Color::class,
        'input.radio' => Widgets\Input\Radio::class,
        'input.label' => Widgets\Input\Label::class,
        'input.groups' => Widgets\Input\Groups::class,
        'input.select' => Widgets\Input\Select::class,
        'input.submit' => Widgets\Input\Submit::class,
        'input.hidden' => Widgets\Input\Hidden::class,
        'input.actions' => Widgets\Input\Actions::class,
        'input.divider' => Widgets\Input\Divider::class,
        'input.checkbox' => Widgets\Input\Checkbox::class,
        'input.password' => Widgets\Input\Password::class,
        'input.textarea' => Widgets\Input\Textarea::class,
    ];

    /**
     * @var array
     */
    protected $contentWidgets = [
        'content.icon' => Widgets\Content\Icon::class,
        'content.text' => Widgets\Content\Text::class,
        'content.heading' => Widgets\Content\Heading::class,
    ];

    /**
     * @var array
     */
    protected $navigationWidgets = [
        'navigation.link' => Widgets\Navigation\Link::class,
        'navigation.button' => Widgets\Navigation\Button::class,
        'navigation.popout-menu' => Widgets\Navigation\PopoutMenu::class,
    ];

    protected $miscWidgets = [
        'partial' => Widgets\Partial::class,
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('build.bauhaus.registrar', Registrar::class);

        app('build.bauhaus.registrar')->register($this->miscWidgets);
        app('build.bauhaus.registrar')->register($this->dataWidgets);
        app('build.bauhaus.registrar')->register($this->inputWidgets);
        app('build.bauhaus.registrar')->register($this->contentWidgets);
        app('build.bauhaus.registrar')->register($this->navigationWidgets);
    }
}
