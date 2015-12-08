<?php
namespace EQM\Models\Palmares;

use EQM\Models\Events\Event;
use EQM\Models\Horses\Horse;
use EQM\Models\Statuses\Status;

interface PalmaresRepository
{
    /**
     * @param int $id
     * @return \EQM\Models\Palmares\Palmares
     */
    public function findById($id);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Palmares\Palmares[]
     */
    public function findPalmaresForHorse(Horse $horse);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Models\Events\Event $event
     * @param \EQM\Models\Statuses\Status $status
     * @param array $values
     * @return \EQM\Models\Palmares\Palmares
     */
    public function create(Horse $horse, Event $event,Status $status, array $values);

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
     * @param array $values
     * @return \EQM\Models\Palmares\Palmares
     */
    public function update(Palmares $palmares, array $values);

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
     */
    public function delete(Palmares $palmares);
}
