# Assets

Asset management in Build-Core is heavily inspired by the [caffeinated/bonsai](https://github.com/caffeinated/bonsai) package.

- [Registering assets](#registering-assets)
- [Defining dependencies](#defining-dependencies)
- [Rendering assets](#rendering-assets)

<a name="registering-assets"></a>
## Registering assets

When adding a new asset to your project, you'll have to define an asset group first.

```php
Asset::make('awesome-styles');
```

After adding your newly created asset group, it's time to add some assets to it. There are two ways to accomplish this task.

#### Directly as a callback.

```php
Asset::make('awesome-styles', function ($group) {
	$group->add('example.css')
});
```

#### After creating the group.

```php
Asset::get('awesome-styles')->add('example.css');
```

<a name="defining-dependencies"></a>
## Defining dependencies

Assets may depend on other assets being loaded before them. You can easily tell Bonsai about any dependencies your asset files may have against each other by using the dependsOn() method.

```php
Asset::add('assets/css/example.css')->dependsOn('bootstrap');
Asset::add('assets/css/bootstrap.css', 'bootstrap');
```

The above will generate the following CSS:

```html
<link rel="stylesheet" href="assets/css/bootstrap.css">
<link rel="stylesheet" href="assets/css/example.css">
```

<a name="rendering-assets"></a>
## Rendering assets

Rendering the assets is a simple as retrieving the asset group by name and calling the appropriate rendering function on that group like so:

```php
Asset::get('awesome-styles')->css();

// or
Asset::get('awesome-scripts')->js();
```