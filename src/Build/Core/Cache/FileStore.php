<?php

namespace Build\Core\Cache;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;

class FileStore extends \Illuminate\Cache\FileStore
{
    /**
     * @var string
     */
    public $separator = '~#~';

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @param  Filesystem  $files
     * @param  string  $directory
     * @param  Repository  $config
     */
    public function __construct(Filesystem $files, string $directory, Repository $config)
    {
        $this->files = $files;
        $this->config = $config;

        parent::__construct($files, $directory);
    }

    /**
     * @param  array|mixed  $names
     * @return TaggedCache
     */
    public function tags($names): TaggedCache
    {
        $names = is_array($names) ? $names : func_get_args();

        return new TaggedCache($this, new TagSet($this, $names));
    }

    /** {@inheritdoc} */
    protected function path($key)
    {
        $isTag = false;
        $split = explode($this->separator, $key);

        if (count($split) > 1) {
            $folder = reset($split).'/';

            if ($folder === 'cache_tags/') {
                $isTag = true;
            }

            $key = end($split);
        } else {
            $key = reset($split);
            $folder = '';
        }

        if ($isTag) {
            $hash = $key;
            $parts = [];
        } else {
            $hash = sha1($key);
            $parts = array_slice(str_split($hash, 2), 0, 2);
        }

        return $this->directory.'/'.$folder.(count($parts) > 0 ? implode('/', $parts).'/' : '').$hash;
    }
}
