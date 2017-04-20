<?php

namespace Build\Core\Support;

use Illuminate\Support\Collection;
use Build\Core\Eloquent\Models\Asset;
use Intervention\Image\ImageManagerStatic as Image;
use Closure;
/**
 * Intervention Image Formatter support class
 */
class ImageFormatter
{

    private $modifications = null;

    /**
     *
     * @var Asset
     */
    private $asset;

    /**
     * Create from Media Asset
     * 
     * @param Asset $asset
     */
    public function __construct(Asset $asset = null)
    {
        $this->modifications = Collection::make();
        $this->asset = $asset;
    }

    /**
     * Retrieve the image modifier url
     * 
     * @return string
     */
    public function url()
    {
        $formats = [];

        foreach ($this->modifications as $modification) {
            $formats[] = $this->formatModification($modification);
        }

        if (empty($formats)) {
            return $this->asset->url;
        } else {
            return route('assets.frontend.formatted', [
                'format' => implode('/', $formats),
                'uuid' => $this->asset->uuid,
            ]);
        }
    }

    /**
     * Parse the modifications
     * 
     * @param string $unparsed The modifications to parse
     * @return \Build\Media\Support\ImageFormatter
     */
    public function parse($unparsed)
    {
        $this->modifications = Collection::make();

        if (empty($unparsed)) {
            return $this;
        }

        $rules = Collection::make(explode('/', $unparsed));

        while ($rules->count()) {
            $command = $rules->shift();
            $args = explode('x', $rules->shift());

            $this->modifications->push(Collection::make(array_merge([$command], $args)));
        }

        return $this;
    }

    /**
     * Set the media asset
     * 
     * @param Asset $asset The Media Asset
     * @return \Build\Media\Support\ImageFormatter
     */
    public function asset(Asset $asset = null)
    {
        if (!$asset) {
            return $this->asset;
        }

        $this->asset = $asset;

        return $this;
    }

    /**
     * Format the modification command
     * 
     * @param array $modification The modification command including arguments as an array
     * @return string The formatted modification as a string
     */
    public function formatModification($modification)
    {
        $all = Collection::make($modification);

        $format = $all->shift();
        $things = '';

        while ($thing = $all->shift()) {
            $things[] = $thing;
        }

        if (empty($things)) {
            return $format;
        }

        $format .= '/' . implode('x', $things);

        return $format;
    }
    
    public function cache( Closure $closure ) {
        if (!class_exists('Intervention\\Image\\ImageCache')) {
            
            $image = Image::make($this->asset->path);
            $this->applyModifications($image);
            
            return $image;
        }
        
        return Image::cache(function ($image) {
                $image->make($this->asset->path);
                $this->applyModifications($image);
            }, 10, true);
    }

    /**
     * Return the cached response in the given format
     * 
     * @return mixed The raw Image response
     */
    public function response($format = null, $quality = null)
    {
        return $this->cache(function ($image) {
                $image->make($this->asset->path);
                $this->applyModifications($image);
            }, 10, true)->response($format, $quality);
    }
    
    private function modifyMaxCommand(&$image, &$command, &$args) {
        $before = 'resize';
        $beforeArgs = $args;

        array_push($beforeArgs, function ($constraint) {
            $constraint->aspectRatio();
        });

        call_user_func_array([$image, $before], $beforeArgs);

        $command = 'resizecanvas';
    }

    /**
     * Applies all the modifications to the Image Resource
     * 
     * @param mixed $image
     * @return \Build\Media\Support\ImageFormatter
     */
    private function applyModifications($image)
    {

        foreach ($this->modifications as $modification) {
            $all = Collection::make($modification);
            $command = $all->shift();
            $args = $all->toArray();
            
            if (method_exists($this, 'modify'. ucwords($command).'Command')) {
                call_user_func_array([$this, 'modify'. ucwords($command).'Command'], [&$image, &$command, &$args]);
            }
            
            call_user_func_array([$image, $command], $args);
        }

        return $this;
    }

    /**
     * Call the image modification methods and buffer them
     * 
     * @param string $name The Image modifier Method name
     * @param array $arguments The modifier attributes
     * @return \Build\Media\Support\ImageFormatter
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $this->modifications->push(Collection::make(array_merge([$name], $arguments)));
        return $this;
    }

}
