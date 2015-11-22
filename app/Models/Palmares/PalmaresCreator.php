<?php
namespace EQM\Models\Palmares;

use EQM\Models\Events\EventRepository;
use EQM\Models\Horses\Horse;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\User;

class PalmaresCreator
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\Events\EventRepository
     */
    private $events;

    /**
     * @var \EQM\Models\Palmares\PalmaresRepository
     */
    private $palmares;

    public function __construct(StatusRepository $statuses, EventRepository $events, PalmaresRepository $palmares)
    {
        $this->statuses = $statuses;
        $this->events = $events;
        $this->palmares = $palmares;
    }

    public function create(Horse $horse, User $user, array $values)
    {
        $values = $this->statuses->createForPalmares($horse, $values);
        $palmaresEvent = $this->events->create($user, $values);
        $this->palmares->create($horse, $palmaresEvent, $values);
    }
}
