<?php

namespace Build\Core\Http\Controllers\Auth;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;

class SessionsController extends Controller
{

    /**
     * @return Response
     */
    public function create()
    {
        return view('build.core::screens.auth.sessions.create');
    }

    /**
     * @return Response|RedirectResponse
     */
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials, $request->get('remember_me'))) {
            return redirect()->intended(config('build.core.uri'));
        }

        return redirect()->back()->withInput()->withErrors([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    /**
     * @return Response
     */
    public function destroy()
    {
        auth()->logout();

        session()->flush();

        return redirect()->guest(config('build.core.uri'));
    }
}