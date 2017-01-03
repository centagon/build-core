<?php

namespace Build\Core\Eloquent\Models;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Ramsey\Uuid\Uuid;
use Build\Core\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use Build\Core\Eloquent\Traits\Groupable;

class Asset extends Model
{

    use Groupable;

    /**
     * Mass-assignment protection.
     * @var array
     */
    protected $fillable = [
        'uuid', 'filename', 'extension', 'filesize', 'mimetype',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function websites()
    {
        return $this->belongsToMany(Website::class);
    }

    /**
     * Get the url attribute.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return asset('media/' . $this->uuid . '.' . $this->extension);
    }

    /**
     * Get the preview url attribute.
     *
     * @return string
     */
    public function getPreviewUrlAttribute()
    {
        return asset('preview-media/' . $this->uuid . '.' . $this->extension);
    }

    /**
     * Get the path attribute.
     *
     * @return string
     */
    public function getPathAttribute()
    {
        return public_path('media/' . $this->uuid . '.' . $this->extension);
    }

    /**
     * Get the path to the media directory.
     *
     * @return string
     */
    public function getDirectoryPathAttribute()
    {
        return public_path('media');
    }

    /**
     * Get the path to the media preview direcotry.
     *
     * @return string
     */
    public function getPreviewDirectoryPathAttribute()
    {
        return public_path('preview-media');
    }

    /**
     * Get the width and height of the image.
     *
     * @return array
     */
    public function getImageSizeAttribute()
    {
        list($width, $height) = @getimagesize($this->path);

        return [
            'width' => $width,
            'height' => $height,
        ];
    }

    public function getFormattedFilesizeAttribute()
    {
        $bytes = $this->getAttribute('filesize');

        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Upload a new file to the media directory.
     *
     * @param UploadedFile $file
     */
    public function upload(UploadedFile $file)
    {
        $filename = $this->getQualifiedFilename($file);

        $file->move($this->directory_path, $filename);
    }

    /**
     * Generate the preview of a given file.
     *
     * @param UploadedFile $file
     */
    public function generatePreview(UploadedFile $file)
    {
        $filename = $this->directory_path . '/' . $this->getQualifiedFilename($file);

        $previewPath = $this->preview_directory_path . '/' . $this->getQualifiedFilename($file);

        Image::make($filename)->resize(235, null, function (Constraint $constraint) {
            $constraint->aspectRatio();
        })->save($previewPath);
    }

    /**
     * Get the qualified file name.
     *
     * @param UploadedFile $file
     *
     * @return string
     */
    protected function getQualifiedFilename(UploadedFile $file)
    {
        return $this->uuid . '.' . $file->getClientOriginalExtension();
    }
    /**
     * Handle the model boot events.
     */
    public static function boot()
    {
        static::creating(function (self $model) {
            $model->setAttribute('uuid', Uuid::uuid1()->toString());
        });
    }
}