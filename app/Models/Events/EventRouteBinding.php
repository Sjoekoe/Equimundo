<?php
namespace EQM\Models\Events;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class EventRouteBinding extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Events\EventRepository
     */
    private $events;

    public function __construct(EventRepository $events)
    {
        $this->events = $events;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Events\Event|null
     */
    public function find($id)
    {
        return $this->events->findById($id);
    }
}
