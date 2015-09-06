<?php
namespace EQM\Listeners\Events;

use EQM\Events\PedigreeWasCreated;
use EQM\Models\Notifications\NotificationRepository;

class NotifyHorseOwner
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

    /**
     * @param \EQM\Events\PedigreeWasCreated $event
     */
    public function handle(PedigreeWasCreated $event)
    {
        if ($event->family->hasOwner()) {
            $this->notifications->create($event->horse->owner()->id, $event->horse->owner()->id, $event->notification, $event->horse, $event->data);
        }
    }
}
