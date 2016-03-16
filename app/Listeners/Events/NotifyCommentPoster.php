<?php
namespace EQM\Listeners\Events;

use EQM\Events\CommentWasLiked;
use EQM\Models\Notifications\NotificationCreator;

class NotifyCommentPoster
{
    /**
     * @var \EQM\Models\Notifications\NotificationCreator
     */
    private $creator;

    public function __construct(NotificationCreator $creator)
    {
        $this->creator = $creator;
    }

    public function handle(CommentWasLiked $event)
    {
        $receiver = $event->comment->poster();
        $sender = $event->user;

        $this->creator->create($sender, $receiver, $event->notification, $event->comment->status(), $event->data);
    }
}
