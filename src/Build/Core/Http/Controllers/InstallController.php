<?php

namespace Build\Core\Http\Controllers;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PDO;
use PDOException;
use Build\Core\Http\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Build\Core\Http\Requests\InstallRequest;
use Illuminate\Contracts\Filesystem\Filesystem;

class InstallController extends Controller
{

    /**
     * @param  Filesystem  $files
     */
    public function __construct(Filesystem $files)
    {
        $this->files = $files;
    }

    /**
     * @return RedirectResponse|View
     */
    public function index()
    {
        // Check if we already installed build. If this is the case
        // then we can just redirect to user to the dashboard.
        if ($this->files->exists(storage_path('app/install'))) {
            return redirect()->route('admin.dashboard');
        }

        // Get the environment file.
        $env = file_get_contents(base_path('.env'));

        return view('build.core::screens.install.index')->with([
            'env' => $env
        ]);
    }

    public function run(InstallRequest $request)
    {
        // Temporarily store the contents of the .env file so that
        // we can later use it when the installation fails.
        $environmentBackup = file_get_contents(base_path('.env'));

        // Save the environment file.
        file_put_contents(base_path('.env'), $request->env);

        // Check if we can make contact to the database with the new settings.
        if (! $this->checkDatabaseConnection($request)) {
            alert()->alert('Cannot connect to the database.')->flash();

            // Restore the environment file.
            file_put_contents(base_path('.env'), $environmentBackup);

            return redirect()->back();
        }

        // Publish the vendor
        Artisan::call('vendor:publish', [
            '--provider' => 'Build\\Core\\ServiceProvider'
        ]);

        // Migrate the database
        Artisan::call('migrate');

        Artisan::call('db:seed', ['--class' => 'Build\Core\Eloquent\Seeders\RolesTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'Build\Core\Eloquent\Seeders\UserTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'Build\Core\Eloquent\Seeders\LanguageTableSeeder']);
        Artisan::call('db:seed', ['--class' => 'Build\Core\Eloquent\Seeders\WebsiteTableSeeder']);

        $this->files->put('install', date('Y-m-d H:i:s'));

        return redirect()->route('admin.dashboard');
    }

    protected function checkDatabaseConnection($request)
    {
        $env = [];

        foreach (explode("\n", $request->env) as $k => $v) {
            $line = explode('=', $v);

            if (! isset($line[1])) {
                continue;
            }

            $env[$line[0]] = trim($line[1]);
        }

        $connection = sprintf(
            '%s:host=%s;port=%s;dbname=%s',
            $env['DB_CONNECTION'],
            $env['DB_HOST'],
            $env['DB_PORT'],
            $env['DB_DATABASE']
        );

        try {
            new PDO($connection, $env['DB_USERNAME'], $env['DB_PASSWORD']);
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }
}