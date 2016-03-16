<?php
namespace EQM\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InvitationWasSent extends Event implements ShouldBroadcast
{
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
