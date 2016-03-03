<?php
namespace EQM\Models\Invites;

use Illuminate\Support\ServiceProvider;

class InviteServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(FriendInvitesRepository::class, function() {
            return new EloquentFriendInvitesRepository(new EloquentFriendInvites());
        });
    }

    public function provides()
    {
        return [
            FriendInvitesRepository::class,
        ];
    }
}
