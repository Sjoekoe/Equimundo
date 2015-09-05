<?php
namespace EQM\Models\Palmares;

use EQM\Models\Events\EloquentEventRepository;
use EQM\Models\Statuses\StatusRepository;

class PalmaresDeleter
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;
    /**
     * @var \EQM\Models\Events\EloquentEventRepository
     */
    private $events;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\Events\EloquentEventRepository $events
     */
    public function __construct(StatusRepository $statuses, EloquentEventRepository $events)
    {
        $this->statuses = $statuses;
        $this->events = $events;
    }

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
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
