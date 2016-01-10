<?php
namespace EQM\Listeners\Events;

use EQM\Events\CommentWasLiked;
use EQM\Models\Notifications\NotificationRepository;
use Illuminate\Auth\AuthManager;

class NotifyCommentPoster
{
    /**
     * @var \EQM\Models\Notifications\NotificationRepository
     */
    private $notifications;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    public function __construct(NotificationRepository $notifications, AuthManager $auth)
    {
        $this->notifications = $notifications;
        $this->auth = $auth;
    }

    public function handle(CommentWasLiked $event)
    {
        $receiver = $event->comment->poster();
        $sender = $event->user;

        $this->notifications->create($sender, $receiver, $event->notification, $event->comment->status(), $event->data);
    }
}
