<?php
namespace HorseStories\Listeners\Events;

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

    public function handle($event)
    {
        $this->creator->create($event->sender, $event->status->user(), $event->notification, $event->status, $event->data);
    }
}
