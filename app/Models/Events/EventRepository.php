<?php
namespace EQM\Models\Events;

class EventRepository
{
    /**
     * @var \EQM\Models\Events\Event
     */
    private $event;

    /**
     * @param \EQM\Models\Events\Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Events\Event
     */
    public function findById($id)
    {
        return $this->event->findOrFail($id);
    }
}
