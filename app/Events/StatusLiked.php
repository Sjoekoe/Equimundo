<?php
namespace EQM\Events;

use EQM\Models\Statuses\Status;
use EQM\Models\Users\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class StatusLiked extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * @var \EQM\Models\Statuses\Status
     */
    public $status;

    /**
     * @var \EQM\Models\Users\User
     */
    public $sender;

    /**
     * @var int
     */
    public $notification;

    /**
     * @var array
     */
    public $data;

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @param \EQM\Models\Users\User $sender
     * @param int $notification
     * @param array $data
     */
    public function __construct(Status $status, User $sender, $notification, $data)
    {
        $this->status = $status;
        $this->sender = $sender;
        $this->notification = $notification;
        $this->data = $data;
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
