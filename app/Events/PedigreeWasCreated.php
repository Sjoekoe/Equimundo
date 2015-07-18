<?php
namespace HorseStories\Events;

use HorseStories\Models\Horses\Horse;
use Illuminate\Queue\SerializesModels;

class PedigreeWasCreated extends Event
{
    use SerializesModels;

    /**
     * @var \HorseStories\Models\Horses\Horse
     */
    public $horse;

    /**
     * @var \HorseStories\Models\Horses\Horse
     */
    public $family;

    /**
     * @var int
     */
    public $notification;

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param \HorseStories\Models\Horses\Horse $family
     * @param int $notification
     */
    public function __construct(Horse $horse, Horse $family, $notification)
    {
        $this->horse = $horse;
        $this->family = $family;
        $this->notification = $notification;
    }
}
