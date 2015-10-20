<?php
namespace EQM\Events;

use EQM\Models\Horses\Horse;

class PalmaresWasCreated extends Event
{
    /**
     * @var \EQM\Models\Horses\Horse
     */
    public $horse;

    /**
     * @var array
     */
    public $values;

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     */
    public function __construct(Horse $horse, array $values)
    {
        $this->horse = $horse;
        $this->values = $values;
    }
}
