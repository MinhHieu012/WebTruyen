<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class LastLoggedIn
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        $event->user->update([
            'last_login_time' => now()->toDateTimeString(),
            'last_login_ip'   => request()->ip(),
        ]);
    }
}
