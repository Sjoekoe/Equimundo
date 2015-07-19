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
     * @var array
     */
    public $data;

    /**
     * @param \HorseStories\Models\Statuses\Status $status
     * @param \HorseStories\Models\Users\User $sender
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
}
