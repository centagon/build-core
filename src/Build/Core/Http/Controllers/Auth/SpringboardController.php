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

class SpringboardController extends Controller
{

    /**
     * @return Response|RedirectResponse
     */
    public function index(Guard $guard)
    {
        // Check if the user has a default Role ; If so, he has access to any website
        if ($guard->user()->getRole(null)) {
            $websites = Website::all();
        } else {
            // Filter the websites that the user has access to
            $websites = Website::all()->filter(function ($value) use ($guard) {
                return ($guard->user()->getRole($value->id, true) ? true : false);
            });
        }

        // Don't show the website selector when the user
        // has only one website.
        if ($websites->count() === 1) {
            return $this->open($websites->first());
        }

        $response = view('build.core::screens.auth.springboard.show')
            ->with(compact('websites'));

        // Return 401: Unauthorized when rendering this route. This is used to
        // catch ajax errors when laravel forgot our site we're logged into.
        return response($response, 401);
    }

    /**
     * @param  Website  $website
     *
     * @return RedirectResponse
     */
    public function open(Website $website)
    {
        session()->put('backend.website_id', $website->getKey());

        return redirect()->intended(config('build.core.uri'));
    }
}
