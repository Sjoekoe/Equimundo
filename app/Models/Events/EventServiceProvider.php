<?php
namespace EQM\Models\Events;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(EventRepository::class, function() {
            return new EloquentEventRepository(new EloquentEvent());
        });
    }
}
