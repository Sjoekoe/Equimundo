<?php
namespace EQM\Listeners\Events;

use EQM\Events\PalmaresWasCreated;
use EQM\Models\Events\EventRepository;
use EQM\Models\Palmares\PalmaresRepository;
use EQM\Models\Statuses\StatusCreator;
use Illuminate\Auth\AuthManager;

class CreatePalmares
{
    /**
     * @var \EQM\Models\Statuses\StatusCreator
     */
    private $statusCreator;

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
     * @param \EQM\Models\Statuses\StatusCreator $statusCreator
     * @param \EQM\Models\Events\EventRepository $events
     * @param \Illuminate\Auth\AuthManager $auth
     * @param \EQM\Models\Palmares\PalmaresRepository $palmares
     */
    public function __construct(StatusCreator $statusCreator, EventRepository $events, AuthManager $auth, PalmaresRepository $palmares)
    {
        $this->statusCreator = $statusCreator;
        $this->events = $events;
        $this->auth = $auth;
        $this->palmares = $palmares;
    }

    /**
     * @param \EQM\Events\PalmaresWasCreated $event
     */
    public function handle(PalmaresWasCreated $event)
    {
        $values = $event->values;

        $values = $this->statusCreator->createForPalmares($event->horse, $values);
        $palmaresEvent = $this->events->create($this->auth->user(), $values);
        $this->palmares->create($event->horse, $palmaresEvent, $values);
    }
}
