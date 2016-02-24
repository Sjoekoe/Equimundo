<?php
namespace EQM\Models\Users;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(UserRepository::class, function() {
            return new EloquentUserRepository(new EloquentUser());
        });

        $this->app->singleton(UserInterestRepository::class, function() {
            return new EloquentUserInterestRepository();
        });
    }

    public function provides()
    {
        return [
            UserRepository::class,
            UserInterestRepository::class,
        ];
    }
}
