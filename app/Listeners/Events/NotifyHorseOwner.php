<?php
namespace HorseStories\Listeners\Events;

use HorseStories\Events\PedigreeWasCreated;
use HorseStories\Models\Notifications\NotificationCreator;

class NotifyHorseOwner
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

    /**
     * @param \HorseStories\Events\PedigreeWasCreated $event
     */
    public function handle(PedigreeWasCreated $event)
    {
        if ($event->family->hasOwner()) {
            $this->creator->create($event->horse->owner()->id, $event->horse->owner()->id, $event->notification, $event->horse);
        }
    }
}
