<?php
namespace EQM\Core\JWT;

use Illuminate\Support\ServiceProvider;

class JWTServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->bind(TokenGenerator::class, TymonTokenGenerator::class);
    }

    public function provides()
    {
        return [TokenGenerator::class];
    }
}
