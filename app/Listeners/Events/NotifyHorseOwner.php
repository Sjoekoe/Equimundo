<?php
namespace EQM\Listeners\Events;

use EQM\Events\PedigreeWasCreated;
use EQM\Models\Notifications\NotificationCreator;

class NotifyHorseOwner
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

    /**
     * @param \EQM\Events\PedigreeWasCreated $event
     */
    public function handle(PedigreeWasCreated $event)
    {
        if ($event->family->hasOwner()) {
            $this->creator->create($event->horse->owner()->id, $event->horse->owner()->id, $event->notification, $event->horse, $event->data);
        }
    }
}
