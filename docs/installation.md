# Installation

To install Build in your latest and greatest laravel
project, you'll need to follow a couple of easy steps:

- [Add Build-Core to your composer file](#update-composer)
- [Registering the package](#register-package)
- [Update the application kernel](#update-kernel)
- [Update the auth config](#update-auth-config)
- [Open the installation page](#open-installation)

<a name="update-composer"></a>
## Add Build-Core to your composer file

Open the `composer.json` file in the root of your project
and add the latest version of `centagon/build-core` to the
file like so:

```
"require": {
	"centagon/build-core": "^1.0"
}
```

After that's done the only thing that you'll need to
do is run composer update.

```
$ composer up
```

<a name="register-package"></a>
## Registering the package

Open `config/app.php` and scroll to the `providers` array key and
add the following:

```
'providers' => [
	//...
	Build\Core\ServiceProvider::class
]
```

<a name="update-kernel"></a>
## Update the application kernel

Open your `app/Http/Kernel.php` file and add the following trait to the top of the class:

```
class Kernel extends HttpKernel
{
	use \Build\Core\Http\Kernel;
	// ...
}
```

<a name="update-auth-config"></a>
## Update the auth config

Open the config/auth.php file and replace the user model with Build\Core\Eloquent\Models\User like so:

```
'providers' => [
	'users' => [
		'driver' => 'eloquent',
		'model' => Build\Core\Eloquent\Models\User::class
	],
]
```

<a name="open-installation"></a>
## Open the installation page

Once you've completed all the above steps it's save to proceed
with the installation in your browser. Go to `http://your-awesome-host/admin/install`
and follow the installation instructions.