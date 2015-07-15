<?php
namespace HorseStories\Events;

use HorseStories\Models\Statuses\Status;
use HorseStories\Models\Users\User;
use Illuminate\Queue\SerializesModels;

class CommentWasPosted extends Event
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

    /**
     * @var int
     */
    public $notification;

    /**
     * @param \HorseStories\Models\Statuses\Status $status
     * @param \HorseStories\Models\Users\User $sender
     * @param int $notification
     */
    public function __construct(Status $status, User $sender, $notification)
    {
        $this->status = $status;
        $this->sender = $sender;
        $this->notification = $notification;
    }
}
