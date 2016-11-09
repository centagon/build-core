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
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{

    public function index()
    {
        return view('build.core::screens.dashboard');
    }
}
