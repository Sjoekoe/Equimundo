<?php
namespace EQM\Listeners\Events;

use EQM\Models\Notifications\NotificationRepository;

class NotifyStatusPoster
{
    /**
     * @var \EQM\Models\Notifications\NotificationRepository
     */
    private $notifications;

    /**
     * @param \EQM\Models\Notifications\NotificationRepository $notifications
     */
    public function __construct(NotificationRepository $notifications)
    {
        $this->notifications = $notifications;
    }

    public function handle($event)
    {
        $this->notifications->create($event->sender, $event->status->user(), $event->notification, $event->status, $event->data);
    }
}
