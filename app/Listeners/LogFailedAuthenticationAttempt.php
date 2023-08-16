<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MikeMcLin\WpPassword\Facades\WpPassword;

class LogFailedAuthenticationAttempt
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = User::where('email', $event->credentials['email'])->first();
        if ($user) {
            if (WpPassword::check($event->credentials['password'], $user->password)) {
                Auth::login($user);
                $user->password = Hash::make($event->credentials['password']);
                $user->save();
            }
        }
    }
}
