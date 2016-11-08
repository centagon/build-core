<?php

namespace Build\Core\Listeners;

/*
 * This file is part of the Build package.
 *
 * (c) Centagon <contact@centagon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Build\Core\Eloquent\Models\User;
use Build\Core\Eloquent\Models\Login;

class LoginAttempt
{

    protected $event;

    public function handle($event)
    {
        $this->event = $event;

        if (isset($this->event->credentials)) {
            $this->logAttempt();
        }

        if (isset($this->event->user)) {
            $this->logSuccess();
        }
    }

    protected function logAttempt()
    {
        $user = User::where('email', $this->event->credentials['email'])->firstOrFail();

        $login = new Login(['type' => Login::TYPE_ATTEMPT]);
        $login->user()->associate($user);
        $login->save();

        return $login;
    }

    protected function logSuccess()
    {
        $user = $this->event->user->id;

        $login = new Login(['type' => Login::TYPE_SUCCESS]);
        $login->user()->associate($user);
        $login->save();

        // Try to clean-up the login attempts.
        Login::where([
                'user_id' => $user,
                'type' => Login::TYPE_ATTEMPT
            ])
            ->whereBetween('created_at', [
                $login->created_at->subSeconds(3), $login->created_at
            ])
            ->delete();
    }
}