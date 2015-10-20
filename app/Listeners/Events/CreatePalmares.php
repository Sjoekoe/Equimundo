<?php
namespace EQM\Listeners\Events;

use EQM\Events\PalmaresWasCreated;
use EQM\Models\Events\EventRepository;
use EQM\Models\Palmares\PalmaresRepository;
use EQM\Models\Statuses\StatusRepository;
use Illuminate\Auth\AuthManager;

class CreatePalmares
{
    /**
     * @var \EQM\Models\Events\EventRepository
     */
    private $events;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @var \EQM\Models\Palmares\PalmaresRepository
     */
    private $palmares;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @param \EQM\Models\Statuses\StatusCreator $statusCreator
     * @param \EQM\Models\Events\EventRepository $events
     * @param \Illuminate\Auth\AuthManager $auth
     * @param \EQM\Models\Palmares\PalmaresRepository $palmares
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     */
    public function __construct(EventRepository $events, AuthManager $auth, PalmaresRepository $palmares, StatusRepository $statuses)
    {
        $this->events = $events;
        $this->auth = $auth;
        $this->palmares = $palmares;
        $this->statuses = $statuses;
    }

    /**
     * @param \EQM\Events\PalmaresWasCreated $event
     */
    public function handle(PalmaresWasCreated $event)
    {
        $values = $event->values;

        $values = $this->statuses->createForPalmares($event->horse, $values);
        $palmaresEvent = $this->events->create($this->auth->user(), $values);
        $this->palmares->create($event->horse, $palmaresEvent, $values);
    }
}
