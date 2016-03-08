<?php namespace EQM\Events;

use EQM\Models\Users\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var \EQM\Models\Users\User
     */
    public $user;

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['admin-dashboard'];
    }
}
