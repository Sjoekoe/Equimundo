<?php
namespace EQM\Models\Events;

use EQM\Models\Users\User;

class EloquentEventRepository implements EventRepository
{
    /**
     * @var \EQM\Models\Events\EloquentEvent
     */
    private $event;

    /**
     * @param \EQM\Models\Events\EloquentEvent $event
     */
    public function __construct(EloquentEvent $event)
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

    /**
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Events\Event
     */
    public function create(User $user, $values)
    {
        $event = new EloquentEvent();

        $event->name = $values['event_name'];
        $event->creator_id = $user->id;

        $event->save();

        return $event;
    }
}
