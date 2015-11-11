<?php
namespace EQM\Models\Users;

use Illuminate\Auth\Guard;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->extendAuth();
    }

    public function register()
    {
    }

    private function extendAuth()
    {
        $this->app['auth']->extend('eloquent', function ($app) {
            $users = $app[EloquentUserRepository::class];

            $userProvider = new EloquentUserProvider($app['hash'], $users);

            return new Guard($userProvider, $app['session.store']);
        });
    }
}
