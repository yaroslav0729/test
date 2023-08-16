<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Exception;
use Socialite;

class SocialController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function loginWithFacebook()
    {
        try {

            $user = Socialite::driver('facebook')->user();
            $isUser = User::where('facebook_id', $user->id)->first();

            if ($isUser) {
                Auth::login($isUser);
                return redirect('/dashboard');
            } else {

                $localUser = User::where('email', $user->email)->first();

                if ($localUser) {

                    $localUser->facebook_id = $user->id;
                    $localUser->save();

                    Auth::login($localUser);
                } else {
                    $createUser = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'facebook_id' => $user->id,
                        'password' => encrypt('admin@123'),
                    ]);

                    Auth::login($createUser);
                }

                return redirect('/dashboard');
            }

        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }
}
