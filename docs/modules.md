# Modules

- [Module structure](#module-structure)
- [Manifest file](#manifest-file)
- [Service provider](#service-provider)
- [Composer support](#composer-support)

<a name="module-structure"></a>
## Module structure

Modules follow the same app structure adopted with the latest version of Laravel, ensuring that modules
feel like a natural part of your application.

To get Core to notice a new module, you have to provide [the manifest file](#manifest-file) and the [service provider](#service-provider) following the structure below:

```
laravel-project/
	app/
	|-- Modules/
		|-- Blog/
			|-- Providers/
				|-- BlogServiceProvider.php
			|-- manifest.json
```

<a name="manifest-file"></a>
## Manifest file

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

<a name="service-provider"></a>
## Service provider

There's nothing special about the service providers for your modules. See the [Laravel documentation](https://laravel.com/docs/providers) for more information on this topic.

<a name="composer-support"></a>
## Composer support

Bringing in Composer support for individual modules is simple through the use of
[Wikimedia's Composer Merge Plugin](https://github.com/wikimedia/composer-merge-plugin).

Simply add the required merge plugin's extra configuration to your application's composer.json file and
point it to your module's directory. You only need to do this once:

```json
"extra": {
    "merge-plugin": {
        "include": [
            "app/Modules/*/composer.json"
        ]
    }
}
```

Now, for every module that requires their own composer dependencies to be installed with your
application, simply create a `composer.json` file at the root of your module:

Then simply run `composer update` per normal! Wikimedia's composer merge plugin will automatically
parse all of your modules `composer.json` files and merge them with your main `composer.json` file dynamically.