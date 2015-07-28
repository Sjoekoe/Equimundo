<?php
namespace EQM\Events;

use EQM\Models\Horses\Horse;
use Illuminate\Queue\SerializesModels;

class HorseWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var \EQM\Models\Horses\Horse
     */
    public $horse;

    /**
     * @param \EQM\Models\Horses\Horse $horse
     */
    public function __construct(Horse $horse)
    {
        $this->horse = $horse;
    }
}
