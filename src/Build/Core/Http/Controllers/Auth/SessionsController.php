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
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SessionsController extends Controller
{

    use ValidatesRequests;
    use ThrottlesLogins;

    /**
     * @return Response
     */
    public function create()
    {
        return view('build.core::screens.auth.sessions.create');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  Request  $request
     *
     * @return Response|RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $request->only($this->username(), 'password');

        if (auth()->attempt($credentials, $request->get('remember_me'))) {
            return redirect()->intended(config('build.core.uri'));
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return redirect()->back()->withInput()->withErrors([
            $this->username() => 'These credentials do not match our records.',
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

    /**
     * Validate the user login request.
     *
     * @param  Request  $request
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'email';
    }
}