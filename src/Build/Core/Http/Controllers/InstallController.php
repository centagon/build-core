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

use Build\Core\Http\Controller;
use Illuminate\Contracts\Filesystem\Filesystem;

class InstallController extends Controller
{

    public function index(Filesystem $files)
    {
        $files->put('install', date('Y-m-d H:i:s'));

        return redirect()->route('admin.dashboard');
    }
}