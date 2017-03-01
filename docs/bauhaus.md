# Bauhaus

introduction.

- [Creating entities](#creating-entities)
- [Rendering entities](#rendering-entities)
- [Add data to your entity](#add-data)
- [Available widgets](#available-widgets)
- [Creating new widgets](#creating-new-widgets)

<a name="creating-entities"></a>
## Creating entities

```php
namespace App\Http\Entities;

use Build\Core\Bauhaus\Mapper;
use Build\Core\Bauhaus\Manager;
use Build\Core\Bauhaus\Widgets\Content\Heading;

class MyEntity extends Manager
{

	/**
	 * @return void
	 */
	public function listAction(Mapper $mapper)
	{
		$mapper->add('content.heading', function (Heading $heading) {
			$heading->title('Blog entries');
			$heading->subtitle('Overview');
		});

		// ...
	}
}
```

<a name="rendering-entities"></a>
## Rendering entities

```php
return entity(MyEntity::class, 'listAction');

// Or by calling the render method directly.
// This is best when encountering an error in your entity because
// PHP isn't able to render exceptions on `__toString()` method calls.
return entity(MyEntity::class, 'listAction)
	->render();
```

<a name="add-data"></a>
## Add data to your entity

<a name="available-widgets"></a>
## Available widgets

Build-Core comes with a plethora or widgets pre-installed, buy of-course you can [bring your own](#creating-new-widgets).

- data
	- [data.table](#widget-data-table)
- input
	- [input.asset](#widget-input-table)
	- [input.date](#widget-input-date)
	- [input.file](#widget-input-file)
	- [input.form](#widget-input-form)
	- [input.tags](#widget-input-tags)
	- [input.text](#widget-input-text)
	- [input.date](#widget-input-date)
	- [input.datetime](#widget-input-datetime)
	- [input.email](#widget-input-email)
	- [input.color](#widget-input-color)
	- [input.radio](#widget-input-radio)
	- [input.label](#widget-input-label)
	- [input.groups](#widget-input-groups)
	- [input.select](#widget-input-select)
	- [input.submit](#widget-input-submit)
	- [input.hidden](#widget-input-hidden)
	- [input.actions](#widget-input-actions)
	- [input.divider](#widget-input-divider)
	- [input.checkbox](#widget-input-checkbox)
	- [input.password](#widget-input-password)
	- [input.textarea](#widget-input-textarea)
- content
	- [content.icon](#widget-content-icon)
	- [content.text](#widget-content-text)
	- [context.heading](#widget-content-heading)
- navigation
	- [navigation.link](#widget-navigation-link)
	- [navigation.button](#widget-navigation-button)
	- [navigation.popout-menu](#widget-navigation-popout-menu)