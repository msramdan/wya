<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class LogSuccessfulLogout
{

    public function handle(Logout $event)
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
            ->event('Logout')
            ->withProperties(['attributes' => $attributes])
            ->tap(function (Activity $activity) use ($hospital_id) {
                $activity->hospital_id = $hospital_id;
            })
            ->log("User {$user->name} berhasil logout");
    }
}
