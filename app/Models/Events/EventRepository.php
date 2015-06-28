<?php
namespace HorseStories\Models\Events;

class EventRepository
{
    /**
     * @var \HorseStories\Models\Events\Event
     */
    private $event;

    /**
     * @param \HorseStories\Models\Events\Event $event
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @param int $id
     * @return \HorseStories\Models\Events\Event
     */
    public function findById($id)
    {
        return $this->event->findOrFail($id);
    }
}
