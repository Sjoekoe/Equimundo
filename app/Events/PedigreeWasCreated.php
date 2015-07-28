<?php
namespace EQM\Events;

use EQM\Models\Horses\Horse;
use Illuminate\Queue\SerializesModels;

class PedigreeWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var \EQM\Models\Horses\Horse
     */
    public $horse;

    /**
     * @var \EQM\Models\Horses\Horse
     */
    public $family;

    /**
     * @var int
     */
    public $notification;

    /**
     * @var array
     */
    public $data;

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Models\Horses\Horse $family
     * @param int $notification
     * @param array $data
     */
    public function __construct(Horse $horse, Horse $family, $notification, $data)
    {
        $this->horse = $horse;
        $this->family = $family;
        $this->notification = $notification;
        $this->data = $data;
    }
}
