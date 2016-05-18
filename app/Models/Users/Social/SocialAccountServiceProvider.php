<?php
namespace EQM\Models\Users\Social;

use Illuminate\Support\ServiceProvider;

class SocialAccountServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(SocialAccountRepository::class, function() {
            return new EloquentSocialAccountRepository(new EloquentSocialAccount());
        });
    }

    public function provides()
    {
        return [
             SocialAccountRepository::class,
        ];
    }
}
