<?php
namespace EQM\Listeners\Events;

use EQM\Events\PalmaresWasDeleted;
use EQM\Models\Events\EventRepository;
use EQM\Models\Palmares\PalmaresRepository;
use EQM\Models\Statuses\StatusRepository;

class DeletePalmares
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\Events\EventRepository
     */
    private $events;

    /**
     * @var \EQM\Models\Palmares\Repository
     */
    private $palmares;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\Events\EventRepository $events
     * @param \EQM\Models\Palmares\PalmaresRepository $palmares
     */
    public function __construct(StatusRepository $statuses, EventRepository $events, PalmaresRepository $palmares)
    {
        $this->statuses = $statuses;
        $this->events = $events;
        $this->palmares = $palmares;
    }

    /**
     * @param \EQM\Events\PalmaresWasDeleted $event
     */
    public function handle(PalmaresWasDeleted $event)
    {
        $status = $this->statuses->findById($event->palmares->status()->id);
        $status->delete();

        $palmaresEvent = $this->events->findById($event->palmares->event()->id());
        $palmaresEvent->delete();

        $this->palmares->delete($event->palmares);
    }
}
