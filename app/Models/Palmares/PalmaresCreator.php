<?php
namespace EQM\Models\Palmares;

use DateTime;
use EQM\Models\Events\EventRepository;
use EQM\Models\Horses\Horse;
use EQM\Models\Statuses\StatusCreator;

class PalmaresCreator
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
     * @param \EQM\Models\Statuses\StatusCreator $statusCreator
     * @param \EQM\Models\Events\EventRepository $events
     */
    public function __construct(StatusCreator $statusCreator, EventRepository $events)
    {
        $this->statusCreator = $statusCreator;
        $this->events = $events;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     */
    public function create(Horse $horse, array $values)
    {
        $values = $this->statusCreator->createForPalmares($horse, $values);

        $event = $this->events->create(auth()->user(), $values);

        $palmares = new Palmares();
        $palmares->horse_id = $horse->id;
        $palmares->discipline = $values['discipline'];
        $palmares->level = $values['level'];
        $palmares->ranking = $values['ranking'];
        $palmares->date = DateTime::createFromFormat('d/m/Y', $values['date']);
        $palmares->status_id = $values['status']->id;
        $palmares->event_id = $event->id;

        $palmares->save();
    }
}
