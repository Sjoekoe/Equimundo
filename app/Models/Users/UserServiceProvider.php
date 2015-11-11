<?php
namespace EQM\Models\Users;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(UserRepository::class, function() {
            return new EloquentUserRepository(new EloquentUser());
        });
    }

    public function register()
    {
    }
}
