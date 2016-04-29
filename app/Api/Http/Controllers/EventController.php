<?php
namespace EQM\Api\Http\Controllers;

use EQM\Api\Events\EventTransformer;
use EQM\Api\Events\Requests\StoreEventRequest;
use EQM\Api\Http\Controller;
use EQM\Models\Events\Event;
use EQM\Models\Events\EventCreator;
use EQM\Models\Events\EventRepository;
use EQM\Models\Events\EventUpdater;

class EventController extends Controller
{
    /**
     * @var \EQM\Models\Events\EventRepository
     */
    private $events;

    public function __construct(EventRepository $events)
    {
        $this->events = $events;
    }

    public function index()
    {
        $events = $this->events->findAllPaginated();

        return $this->response()->paginator($events, new EventTransformer());
    }

    public function store(StoreEventRequest $request, EventCreator $creator)
    {
        $event = $creator->create(auth()->user(), $request->all());

        return $this->response()->item($event, new EventTransformer());
    }

    public function show(Event $event)
    {
        return $this->response()->item($event, new EventTransformer());
    }

    public function update(StoreEventRequest $request, EventUpdater $updater, Event $event)
    {
        $event = $updater->update($event, $request->all());

        return $this->response()->item($event, new EventTransformer());
    }

    public function delete(Event $event)
    {
        $this->events->delete($event);

        return $this->response()->noContent();
    }
}
