<?php

namespace Build\Core\Support;

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
        if ( File::mimeType($filename) == "application/pdf" ) return false;
        return true;
    }

}