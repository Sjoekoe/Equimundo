<?php
namespace HorseStories\Events;

use HorseStories\Models\Statuses\Status;
use HorseStories\Models\Users\User;
use Illuminate\Queue\SerializesModels;

class StatusLiked extends Event
{
    use SerializesModels;

    /**
     * @var \HorseStories\Models\Statuses\Status
     */
    public $status;

    /**
     * @var \HorseStories\Models\Users\User
     */
    public $sender;

    public function __construct(Status $status, User $sender)
    {
        $this->status = $status;
        $this->sender = $sender;
    }
}
