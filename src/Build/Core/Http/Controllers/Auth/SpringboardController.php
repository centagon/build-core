<?php

namespace Build\Core\Http\Controllers\Auth;

/*
 * This file is part of the Core package.
 *
 * (c) Build <hello@krafthaus.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Build\Core\Eloquent\Models\Website;
use Build\Core\Http\Requests\SpringboardRequest;

class SpringboardController extends Controller
{

    /**
     * @return Response
     */
    public function index(Guard $guard)
    {
        // Check if the user has a default Role ; If so, he has access to any website
        if ($guard->user()->getRole(null)) {
            $websites = Website::all();
        } else {
            // Filter the websites that the user has access to
            $websites = Website::all()->filter(function ($value) use ($guard) {
                return ($guard->user()->getRole($value->id, true) ? true:false);
            });
        }

        return view('build.core::screens.auth.springboard.show')->with(compact('websites'));
    }

    /**
     * @param  Website  $website
     *
     * @return RedirectResponse
     */
    public function open(Website $website)
    {
        session()->put('backend.website_id', $website->getKey());

        return redirect()->to(config('build.core.uri'));
    }
}
