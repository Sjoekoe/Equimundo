<?php
namespace EQM\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);
    }
}
