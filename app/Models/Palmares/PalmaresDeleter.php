<?php
namespace HorseStories\Models\Palmares;

use HorseStories\Models\Events\EventRepository;
use HorseStories\Models\Statuses\StatusRepository;

class PalmaresDeleter
{
    /**
     * @var \HorseStories\Models\Statuses\StatusRepository
     */
    private $statuses;
    /**
     * @var \HorseStories\Models\Events\EventRepository
     */
    private $events;

    /**
     * @param \HorseStories\Models\Statuses\StatusRepository $statuses
     * @param \HorseStories\Models\Events\EventRepository $events
     */
    public function __construct(StatusRepository $statuses, EventRepository $events)
    {
        $this->statuses = $statuses;
        $this->events = $events;
    }

    /**
     * @param \HorseStories\Models\Palmares\Palmares $palmares
     */
    public function delete(Palmares $palmares)
    {
        $status = $this->statuses->findById($palmares->status->id);
        $status->delete();

        $event = $this->events->findById($palmares->event->id);
        $event->delete();

        $palmares->delete();
    }
}
