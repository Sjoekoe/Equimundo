<?php
namespace EQM\Models\Notifications;

use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(NotificationRepository::class, function() {
            return new EloquentNotificationRepository(new EloquentNotification());
        });
    }
}
