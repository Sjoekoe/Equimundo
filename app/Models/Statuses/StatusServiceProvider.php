<?php
namespace EQM\Models\Statuses;

use Illuminate\Support\ServiceProvider;

class StatusServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(StatusRepository::class, function() {
            return new EloquentStatusRepository(new EloquentStatus());
        });
    }
}
