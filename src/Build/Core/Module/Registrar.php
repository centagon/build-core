<?php

namespace Build\Core\Module;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

class Registrar
{

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @param  Application  $app
     * @param  Filesystem   $files
     */
    public function __construct(Application $app, Filesystem $files)
    {
        $this->app = $app;
        $this->files = $files;
    }

    /**
     * Register the module service provider file from all modules.
     */
    public function register()
    {
        $this->enabled()->each(function ($properties) {
            $this->registerServiceProvider($properties);

            $this->autoloadFiles($properties);
        });
    }

    /**
     * Get all modules.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->getCache()->sortBy('order');
    }

    /**
     * Get all the module slugs.
     *
     * @return Collection
     */
    public function slugs()
    {
        $slugs = collect();

        $this->all()->each(function ($item) use ($slugs) {
            $slugs->push($item['slug']);
        });

        return $slugs;
    }

    /**
     * Get all modules based on a where clause.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return Collection
     */
    public function where($key, $value)
    {
        return $this->all()->where($key, $value)->first();
    }

    /**
     * @param  string  $slug
     *
     * @return Collection
     */
    public function find($slug)
    {
        return $this->where('slug', $slug);
    }

    /**
     * Sort modules by a given key in ascending order.
     *
     * @param  string  $key
     * @param  bool    $descending
     *
     * @return Collection
     */
    public function sortBy($key, $descending = false)
    {
        return $this->all()->sortBy($key, SORT_REGULAR, $descending);
    }

    /**
     * Determine that the given module exists.
     *
     * @param  string  $slug
     *
     * @return bool
     */
    public function exists($slug)
    {
        return $this->slugs()->contains(strtolower($slug));
    }

    /**
     * Returns the count of all modules.
     *
     * @return int
     */
    public function count()
    {
        return $this->all()->count();
    }

    /**
     * Get a module property value.
     *
     * @param  string      $property
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function get($property, $default = null)
    {
        list($slug, $key) = explode('::', $property);

        return $this->where('slug', $slug)->get($key, $default);
    }

    /**
     * Set the given module property values.
     *
     * @param  string  $property
     * @param  mixed  $value
     *
     * @return int
     */
    public function set($property, $value)
    {
        list($slug, $key) = explode('::', $property);

        $module = $this->where('slug', $slug);

        if (isset($module[$key])) {
            unset($module[$key]);
        }

        $module[$key] = $value;

        $module = collect([$module['basename'] => $module]);
        $merged = $this->getCache()->merge($module);

        return $this->files->put($this->getCachePath(), json_encode($merged->all(), JSON_PRETTY_PRINT));
    }

    /**
     * Get all enabled modules.
     *
     * @return Collection
     */
    public function enabled()
    {
        return $this->all()->where('enabled', true);
    }

    /**
     * Get all disabled modules.
     *
     * @return Collection
     */
    public function disabled()
    {
        return $this->all()->where('enabled', false);
    }

    /**
     * Determine that the specified module is enabled.
     *
     * @param  string  $slug
     *
     * @return bool
     */
    public function isEnabled($slug)
    {
        return $this->where('slug', $slug)->first()['enabled'] === true;
    }

    /**
     * Determine that the specified module is disabled.
     *
     * @param  string  $slug
     *
     * @return bool
     */
    public function isDisabled($slug)
    {
        return ! $this->isEnabled($slug);
    }

    /**
     * Enable a specific module.
     *
     * @param  string  $slug
     */
    public function enable($slug)
    {
        $this->set($slug . '::enabled', true);
    }

    /**
     * Disable s specific module.
     *
     * @param  string  $slug
     */
    public function disable($slug)
    {
        $this->set($slug . '::enabled', false);
    }

    /**
     * Register the module service provider.
     *
     * @param  array  $properties
     */
    protected function registerServiceProvider(array $properties)
    {
        $namespace = $this->resolveNamespace($properties);
        $provider = sprintf('%s\\%2$s\\Providers\\%2$sServiceProvider', $this->getNamespace(), $namespace);

        if (class_exists($provider)) {
            $this->app->register($provider);
        }
    }

    /**
     * Autoload custom module files.
     *
     * @param  array  $properties
     */
    protected function autoloadFiles(array $properties)
    {
        if (isset($properties['autoload'])) {
            $namespace = $this->resolveNamespace($properties);

            $path = $this->getPath() . "/{$namespace}/";

            foreach ($properties['autoload'] as $file) {
                require $path . $file;
            }
        }
    }

    /**
     * Resolve the correct module namespace.
     *
     * @param  array  $properties
     *
     * @return string
     */
    protected function resolveNamespace(array $properties)
    {
        return isset($properties['namespace'])
            ? $properties['namespace']
            : studly_case($properties['slug']);
    }

    /**
     * Get a module's manifest contents.
     *
     * @param  string  $slug
     *
     * @return Collection
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getManifest($slug)
    {
        if ($slug) {
            $module = studly_case($slug);

            $path = $this->getManifestPath($module);

            $contents = $this->files->get($path);

            return collect(json_decode($contents, true));
        }

        return collect();
    }

    /**
     * Get all the module basenames.
     *
     * @return Collection
     * @throws \InvalidArgumentException
     */
    protected function getBasenames()
    {
        $path = $this->getPath();

        try {
            $collection = collect($this->files->directories($path));

            return $collection->map(function ($item) {
                return basename($item);
            });
        } catch (\InvalidArgumentException $e) {
            return collect([]);
        }
    }

    /**
     * Get the module path.
     *
     * @return string
     */
    public function getPath()
    {
        return config('build.core.modules-path');
    }

    /**
     * Get the module namespace.
     *
     * @return string
     */
    public function getNamespace()
    {
        return rtrim(config('build.core.modules-namespace'), '/\\');
    }

    /**
     * Get the contents of the cache file.
     *
     * @return Collection
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getCache()
    {
        $path = $this->getCachePath();

        if ( ! $this->files->exists($path)) {
            $content = json_encode([], JSON_PRETTY_PRINT);

            $this->files->put($path, $content);

            $this->updateCache();

            return collect(json_decode($content, true));
        }

        return collect(json_decode($this->files->get($path), true));
    }

    /**
     * Update cached repository of module information.
     *
     * @return int
     */
    public function updateCache()
    {
        $path = $this->getCachePath();
        $cache = $this->getCache();
        $basenames = $this->getBasenames();

        $modules = collect();

        $basenames->each(function ($module) use ($modules, $cache) {
            $basename = collect(['basename' => $module]);
            $temp = $basename->merge(collect($cache->get($module)));
            $manifest = $temp->merge(collect($this->getManifest($module)));

            $modules->put($module, $manifest);

//            $manifest = collect($this->getManifest($module));
//
//            $modules->put($module, collect($cache->get($module))->merge($manifest));
        });

        $modules->each(function ($module) {
            $module->put('id', crc32($module->get('slug')));

            if ( ! $module->has('enabled')) {
                $module->put('enabled', config('build.core.modules-enabled', true));
            }

            if ( ! $module->has('order')) {
                $module->put('order', 9001);
            }

            return $module;
        });

        $content = json_encode($modules->all(), JSON_PRETTY_PRINT);

        return $this->files->put($path, $content);
    }

    /**
     * Get the path to the cache file.
     *
     * @return string
     */
    protected function getCachePath()
    {
        return storage_path('app/modules.json');
    }

    /**
     * Get the path to the specified module.
     *
     * @param  string  $slug
     *
     * @return string
     */
    protected function getModulePath($slug)
    {
        $module = studly_case($slug);

        return sprintf('%s/%s', $this->getPath(), $module);
    }

    /**
     * Get the path to the manifest file of the specified module.
     *
     * @param  string  $slug
     *
     * @return string
     */
    protected function getManifestPath($slug)
    {
        return $this->getModulePath($slug) . '/manifest.json';
    }
}
