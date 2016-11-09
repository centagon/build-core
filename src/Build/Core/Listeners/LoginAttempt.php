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
use Build\Core\Eloquent\Models\LoginAttempt as Attempt;

class LoginAttempt
{

    /**
     * @var mixed
     */
    protected $event;

    /**
     * Handle the Login events.
     *
     * @param  mixed  $event
     */
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

    /**
     * Log the attempt.
     */
    protected function logAttempt()
    {
        $user = User::where('email', $this->event->credentials['email'])->firstOrFail();

        Attempt::log($user, Attempt::TYPE_ATTEMPT);
    }

    /**
     * Log the successfully login.
     */
    protected function logSuccess()
    {
        $user = User::findOrFail($this->event->user->id);

        Attempt::log($user, Attempt::TYPE_SUCCESS);
    }
}
