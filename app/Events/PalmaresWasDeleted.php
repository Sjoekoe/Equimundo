<?php
namespace EQM\Events;

use EQM\Models\Palmares\Palmares;

class PalmaresWasDeleted extends Event
{
    /**
     * @var \EQM\Models\Palmares\Palmares
     */
    public $palmares;

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
     */
    public function __construct(Palmares $palmares)
    {
        $this->palmares = $palmares;
    }
}
