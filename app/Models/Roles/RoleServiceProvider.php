<?php
namespace EQM\Models\Roles;

use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RoleRepository::class, function() {
            return new EloquentRoleRepository();
        });
    }
}
