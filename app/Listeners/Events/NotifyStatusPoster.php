<?php
namespace EQM\Listeners\Events;

use EQM\Models\Notifications\NotificationCreator;

class NotifyStatusPoster
{
    /**
     * @var \EQM\Models\Notifications\NotificationCreator
     */
    private $creator;

    /**
     * @param \EQM\Models\Notifications\NotificationCreator $creator
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
