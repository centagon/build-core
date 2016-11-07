# Build Core for Laravel

[![Total Downloads](https://poser.pugx.org/centagon/build-core/downloads.png)](https://packagist.org/packages/centagon/build-core)
[![License](https://poser.pugx.org/centagon/build-core/license.png)](https://packagist.org/packages/krafthaus/build-core)

## Getting started

Add Build Core to your composer.json file:

```
"require": {
    "centagon/build-core": "^1.0"
}
```

Use composer to install this package.

```
$ composer update
```

### Registering the package

```
'providers' => [
	// ...
	Build\Core\ServiceProvider::class
]
```

### Updating the Application Kernel

Open your `app/Http/Kernel.php` file and add the following trait to the top of the class:

```
class Kernel extends HttpKernel
{
    use \Build\Core\Http\Kernel;
    // ...
}
```

### Using the Build User instead of the Laravel user.

Open the `config/auth.php` file and replace the user model with `Build\Core\Eloquent\Models\User` like so:

```
'providers' => [
	'users' => [
		'driver' => 'eloquent',
		'model' => Build\Core\Eloquent\Models\User::class,
		],
],
```

## Documentation

Documentation can be [found here](https://centagon.github.io/build-core/).

## Contributing

Have a bug? Please create an issue here on GitHub that conforms with
[our contributing guidelines](https://github.com/centagon/guidelines/blob/master/contributing.md).
You can also browse the [Help Wanted](https://github.com/centagon/primer/labels/help%20wanted)
tag in our issue tracker to find things to do.

## License

This package is available under the [MIT license](https://github.com/centagon/primer/blob/master/LICENSE).

Copyright (c) 2016 Centagon, B.V.