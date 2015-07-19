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
     * @var array
     */
    public $data;

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param \HorseStories\Models\Horses\Horse $family
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
