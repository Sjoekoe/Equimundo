<?php
namespace EQM\Events;

use EQM\Models\Notifications\Notification;
use EQM\Models\Users\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NotificationWasSent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var \EQM\Models\Users\User
     */
    public $user;

    /**
     * @var \EQM\Models\Notifications\Notification
     */
    public $notification;

    public function __construct(User $user, Notification $notification)
    {
        $this->user = $user;
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['user-' . $this->user->id()];
    }
}
