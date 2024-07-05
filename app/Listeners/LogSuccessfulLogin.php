<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        $userAgent = request()->header('User-Agent');
        $ipAddress = request()->ip();

        $attributes = [
            'email' => $user->email,
            'name' => $user->name,
            'user_agent' => $userAgent,
            'ip_address' => $ipAddress,
        ];

        activity('log_auth')
            ->performedOn($user)
            ->causedBy($user)
            ->event('Login')
            ->withProperties(['attributes' => $attributes])
            ->log("User {$user->name} berhasil login");
    }
}
