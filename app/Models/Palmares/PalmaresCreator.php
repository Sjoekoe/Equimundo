<?php
namespace HorseStories\Models\Palmares;

use DateTime;
use HorseStories\Models\Events\EventCreator;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Statuses\StatusCreator;

class PalmaresCreator
{
    /**
     * @var \HorseStories\Models\Statuses\StatusCreator
     */
    private $statusCreator;
    /**
     * @var \HorseStories\Models\Events\EventCreator
     */
    private $eventCreator;

    /**
     * @param \HorseStories\Models\Statuses\StatusCreator $statusCreator
     * @param \HorseStories\Models\Events\EventCreator $eventCreator
     */
    public function __construct(StatusCreator $statusCreator, EventCreator $eventCreator)
    {
        $this->statusCreator = $statusCreator;
        $this->eventCreator = $eventCreator;
    }

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
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
