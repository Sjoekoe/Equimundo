<?php
namespace EQM\Models\Palmares;

use EQM\Models\Events\EventRepository;
use EQM\Models\Statuses\StatusRepository;

class PalmaresDeleter
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
     * @var \EQM\Models\Palmares\PalmaresRepository
     */
    private $palmares;


    public function __construct(StatusRepository $statuses, EventRepository $events, PalmaresRepository $palmares)
    {
        $this->statuses = $statuses;
        $this->events = $events;
        $this->palmares = $palmares;
    }

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
     */
    public function delete(Palmares $palmares)
    {
        $this->statuses->delete($palmares->status());
        $this->events->delete($palmares->event());
        $this->palmares->delete($palmares);
    }
}
