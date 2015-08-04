<?php
namespace EQM\Models\Palmares;

use DateTime;
use EQM\Models\Events\EventCreator;
use EQM\Models\Horses\Horse;
use EQM\Models\Statuses\StatusCreator;

class PalmaresCreator
{
    /**
     * @var \EQM\Models\Statuses\StatusCreator
     */
    private $statusCreator;
    /**
     * @var \EQM\Models\Events\EventCreator
     */
    private $eventCreator;

    /**
     * @param \EQM\Models\Statuses\StatusCreator $statusCreator
     * @param \EQM\Models\Events\EventCreator $eventCreator
     */
    public function __construct(StatusCreator $statusCreator, EventCreator $eventCreator)
    {
        $this->statusCreator = $statusCreator;
        $this->eventCreator = $eventCreator;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     */
    public function create(Horse $horse, array $values)
    {
        $values = $this->statusCreator->createForPalmares($horse, $values);
        $event = $this->eventCreator->create($values);

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
