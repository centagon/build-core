<?php

namespace Build\Core\Support;

use Illuminate\Support\Facades\File;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Mime
{
    /**
     * Determine if we can create a preview
     *
     * @param $filename
     *
     * @return bool
     */
    public static function isImage($filename)
    {
        return substr(File::mimeType($filename), 0, 5) == 'image';
    }
}
