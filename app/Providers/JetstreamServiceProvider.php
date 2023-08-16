<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;
use MikeMcLin\WpPassword\Facades\WpPassword;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configurePermissions();

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                if (WpPassword::check($request->password, $user->password)) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                }
                if ($user && Hash::check($request->password, $user->password)) {
                    return $user;
                }
            }
        });

        Jetstream::deleteUsersUsing(DeleteUser::class);

        // register new LoginResponse
        $this->app->singleton(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            \App\Http\Responses\LoginResponse::class
        );

        // register new LoginResponse
        $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            \App\Http\Responses\RegisterResponse::class
        );

        // register new ForgotPassword
        $this->app->singleton(
            \Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse::class,
            \App\Http\Responses\ForgotPasswordResponse::class
        );

        // register new ForgotPassword - failed
        $this->app->singleton(
            \Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse::class,
            \App\Http\Responses\ForgotPasswordResponseFail::class
        );
    }

    /**
     * Configure the permissions that are available within the application.
     *
     * @return void
     */
    protected function configurePermissions()
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
