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
use Build\Core\Bauhaus\Support\Container;

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
        'input.email' => Widgets\Input\Email::class,
        'input.color' => Widgets\Input\Color::class,
        'input.radio' => Widgets\Input\Radio::class,
        'input.select' => Widgets\Input\Select::class,
        'input.hidden' => Widgets\Input\Hidden::class,
        'input.actions' => Widgets\Input\Actions::class,
        'input.checkbox' => Widgets\Input\Checkbox::class,
        'input.password' => Widgets\Input\Password::class,
        'input.textarea' => Widgets\Input\Textarea::class,
    ];

    /**
     * @var array
     */
    protected $contentWidgets = [
        'content.icon' => Widgets\Content\Icon::class,
        'content.heading' => Widgets\Content\Heading::class,
    ];

    /**
     * @var array
     */
    protected $navigationWidgets = [
        'navigation.link' => Widgets\Navigation\Link::class,
        'navigation.button' => Widgets\Navigation\Button::class,
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('build.bauhaus.container', Container::class);

        app('build.bauhaus.container')->register($this->dataWidgets);
        app('build.bauhaus.container')->register($this->inputWidgets);
        app('build.bauhaus.container')->register($this->contentWidgets);
        app('build.bauhaus.container')->register($this->navigationWidgets);
    }
}