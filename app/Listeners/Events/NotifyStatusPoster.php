<?php
namespace HorseStories\Listeners\Events;

use HorseStories\Events\StatusLiked;
use HorseStories\Models\Notifications\Notification;
use HorseStories\Models\Notifications\NotificationCreator;

class NotifyStatusPoster
{
    /**
     * @var \HorseStories\Models\Notifications\NotificationCreator
     */
    private $creator;

    /**
     * @param \HorseStories\Models\Notifications\NotificationCreator $creator
     */
    public function __construct(NotificationCreator $creator)
    {
        $this->creator = $creator;
    }

    public function handle(StatusLiked $event)
    {
        $this->creator->create($event->sender, $event->status->user(), Notification::STATUS_LIKED, $event->status);
    }
}
