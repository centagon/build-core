# Modules

### Module structure

Modules follow the same app structure adopted with the latest version of Laravel, ensuring that modules
feel like a natural part of your application.

```
laravel-project/
	app/
	|-- Modules/
		|-- Blog/
			|-- Console/
			|-- Database/
				|-- Migrations/
				|-- Seeds/
			|-- Http/
				|-- Controllers/
				|-- Middleware/
				|-- Requests/
			|-- Providers/
				|-- BlogServiceProvider/
				|-- RouteServiceProvder/
			|-- Resources/
				|-- lang/
				|-- views/
			|-- manifest.json/
```

### Manifest file

Along with the structure, every module has a `manifest.json` manifest file. This manifest file is used
to outline information such as the description, version, author(s) and anything you'd like to store
pertaining to the module at hand.

```json
{
	"name": "Blog",
	"slug": "blog",
	"version": "1.0",
	"author": "Author name",
	"license": "MIT",
	"description": "The biggest, the best..."
}
```

- __name__ - A human friendly name of the module
- __slug__ - The slug of the module. This is used for identification purposes.
- __version__ - The module's version.
- __description__ - A description of the module.
- __author__ - The module's author name(s).
- __license__ - The module's license.