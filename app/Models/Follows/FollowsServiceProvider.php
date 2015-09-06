<?php
namespace EQM\Models\Follows;

use Illuminate\Support\ServiceProvider;

class FollowsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(FollowsRepository::class, function() {
            return new EloquentFollowsRepository();
        });
    }
}
