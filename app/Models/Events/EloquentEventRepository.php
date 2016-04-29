<?php
namespace EQM\Models\Events;

use Carbon\Carbon;
use EQM\Models\Addresses\Address;
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
        $event->creator_id = $user->id();

        $event->save();

        return $event;
    }

    /**
     * @param \EQM\Models\Events\Event $event
     * @param \EQM\Models\Addresses\Address $address
     * @param array $values
     * @return \EQM\Models\Events\Event
     */
    public function update(Event $event, Address $address, array $values)
    {
        if (array_key_exists('name', $values)) {
            $event->name = $values['name'];
        }

        if (array_key_exists('description', $values)) {
            $event->description = $values['description'];
        }

        if (array_key_exists('start_date', $values)) {
            $event->start_date = Carbon::createFromFormat('d/m/Y', $values['start_date']);
        }

        if (array_key_exists('end_date', $values)) {
            $event->start_date = Carbon::createFromFormat('d/m/Y', $values['end_date']);
        }

        $event->place = $address->city();
        $event->address_id = $address->id();

        $event->save();

        return $event;
    }

    /**
     * @param \EQM\Models\Events\Event $event
     */
    public function delete(Event $event)
    {
        $event->delete();
    }

    /**
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findAllPaginated($limit = 10)
    {
        return $this->event->paginate($limit);
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Addresses\Address $address
     * @param array $values
     * @return \EQM\Models\Events\Event
     */
    public function createFullSizedEvent(User $user, Address $address, array $values)
    {
        $event = new EloquentEvent();
        $event->name = $values['name'];
        $event->description = $values['description'];
        $event->start_date = Carbon::createFromFormat('d/m/Y', $values['start_date']);
        $event->end_date = Carbon::createFromFormat('d/m/Y', $values['end_date']);
        $event->creator_id = $user->id();
        $event->address_id = $address->id();
        $event->place = $address->city();

        $event->save();

        return $event;
    }
}
