<?php
namespace EQM\Models\Palmares;

use Carbon\Carbon;
use EQM\Models\Events\Event;
use EQM\Models\Horses\Horse;
use EQM\Models\Statuses\Status;

class EloquentPalmaresRepository implements PalmaresRepository
{
    /**
     * @var \EQM\Models\Palmares\EloquentPalmares
     */
    private $palmares;

    /**
     * @param \EQM\Models\Palmares\EloquentPalmares $palmares
     */
    public function __construct(EloquentPalmares $palmares)
    {
        $this->palmares = $palmares;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Palmares\EloquentPalmares
     */
    public function findById($id)
    {
        return $this->palmares->findOrFail($id);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Palmares\EloquentPalmares[]
     */
    public function findPalmaresForHorse(Horse $horse)
    {
        return $this->palmares->where('horse_id', $horse->id())->orderBy('date', 'desc')->get();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Models\Events\Event $event
     * @param \EQM\Models\Statuses\Status $status
     * @param array $values
     * @return \EQM\Models\Palmares\Palmares
     */
    public function create(Horse $horse, Event $event, Status $status, array $values)
    {
        $palmares = new EloquentPalmares();
        $palmares->horse_id = $horse->id();
        $palmares->discipline = $values['discipline'];
        $palmares->level = $values['level'];
        $palmares->ranking = $values['ranking'];
        $palmares->date = Carbon::createFromFormat('d/m/Y', $values['date'])->startOfDay();
        $palmares->status_id = $status->id();
        $palmares->event_id = $event->id();

        $palmares->save();

        return $palmares;
    }

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
     * @param array $values
     * @return \EQM\Models\Palmares\Palmares
     */
    public function update(Palmares $palmares, array $values)
    {
        $palmares->discipline = $values['discipline'];
        $palmares->level = $values['level'];
        $palmares->ranking = $values['ranking'];

        if (array_key_exists('date', $values)) {
            $palmares->date = Carbon::createFromFormat('d/m/Y', $values['date'])->startOfDay();
        }

        $palmares->event()->name = $values['event_name'];

        $palmares->save();

        return $palmares;
    }

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
     */
    public function delete(Palmares $palmares)
    {
        $palmares->delete();
    }
}
