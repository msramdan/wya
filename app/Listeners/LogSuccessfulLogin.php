<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

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
        $hospital_id = session('sessionHospital');
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
            ->tap(function (Activity $activity) use ($hospital_id) {
                $activity->hospital_id = $hospital_id;
            })
            ->log("User {$user->name} berhasil login");
    }
}
