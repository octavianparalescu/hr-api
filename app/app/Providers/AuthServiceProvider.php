<?php

namespace App\Providers;

use App\Repository\Auth\AuthTokenRepository;
use App\Repository\Auth\UserRepository;
use App\Validation\Auth\AuthTokenExpirationValidation;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     * @return void
     */
    public function boot(
        AuthTokenRepository $authTokenRepository,
        UserRepository $userRepository,
        AuthTokenExpirationValidation $authTokenExpirationValidation
    ) {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest(
            'api',
            function (Request $request) use ($authTokenRepository, $userRepository, $authTokenExpirationValidation) {
                if ($token = $request->header('auth_token')) {
                    $tokenEntity = $authTokenRepository->fetch($token);
                    if ($tokenEntity && $authTokenExpirationValidation->verifyToken($tokenEntity)) {
                        return $userRepository->fetchByKey($tokenEntity->getUserKey());
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }
            }
        );
    }
}
