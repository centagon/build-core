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

    protected $widgets = [
        'lock.button' => Widgets\Lock\Button::class,

        'input.file' => Widgets\Input\File::class,
        'input.date' => Widgets\Input\Date::class,
        'input.tags' => Widgets\Input\Tags::class,
        'input.text' => Widgets\Input\Text::class,
        'input.email' => Widgets\Input\Email::class,
        'input.color' => Widgets\Input\Color::class,
        'input.radio' => Widgets\Input\Radio::class,
        'input.select' => Widgets\Input\Select::class,
        'input.hidden' => Widgets\Input\Hidden::class,
        'input.actions' => Widgets\Input\Actions::class,
        'input.checkbox' => Widgets\Input\Checkbox::class,
        'input.textarea' => Widgets\Input\Textarea::class,
        'input.password' => Widgets\Input\Password::class,
        'input.relation.hasmany' => Widgets\Input\Relation\HasMany::class,
        'input.relation.belongsto' => Widgets\Input\Relation\BelongsTo::class,
        'input.relation.belongstomany' => Widgets\Input\Relation\BelongsToMany::class,
        'input.relation.belongstothrough' => Widgets\Input\Relation\BelongsToThrough::class,

        'box.color' => Widgets\Color\ColorBox::class,
        'box.websitecolor' => Widgets\Color\WebsiteColor::class,

        'divider' => Widgets\Divider::class,
        'heading' => Widgets\Heading::class,

        'button' => Widgets\Button::class,
        'button.action' => Widgets\Button\ActionButton::class,
        'button.dropdown' => Widgets\Button\Dropdown::class,

        'icon' => Widgets\Icon::class,
        'link' => Widgets\Link::class,
        'form' => Widgets\Form::class,
        'label' => Widgets\Label::class,
        'table' => Widgets\Table::class,
        'accordion' => Widgets\Accordion::class,
        'block-table' => Widgets\BlockTable::class,
        'accordion.item' => Widgets\AccordionItem::class,

        'partial' => Widgets\Partial::class,
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton('build.bauhaus.container', Container::class);

        app('build.bauhaus.container')->register($this->widgets);
    }
}