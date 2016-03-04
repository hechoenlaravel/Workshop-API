<?php

namespace App\Providers;

use App\Auth\UserResolver;
use Illuminate\Support\ServiceProvider;
use Dingo\Api\Auth\Provider\OAuth2;

class OAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app('Dingo\Api\Auth\Auth')->extend('oauth', function ($app) {
            $provider = new OAuth2($app['oauth2-server.authorizer']->getChecker());
            $provider->setClientResolver(function ($id) {
                // Logic to return a client by their ID.
            });
            $provider->setUserResolver(function ($id) {
                $resolver = app(UserResolver::class);
                return $resolver->resolveById($id);
            });
            return $provider;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
