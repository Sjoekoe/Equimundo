<?php
namespace EQM\Events;

use EQM\Models\Horses\Horse;
use EQM\Models\Users\User;
use Illuminate\Queue\SerializesModels;

class HorseWasFollowed extends Event
{
    use SerializesModels;

    /**
     * @var \EQM\Models\Horses\Horse
     */
    public $horse;

    /**
     * @var \EQM\Models\Users\User
     */
    public $user;

    /**
     * @var
     */
    public $notification;

    /**
     * @var array
     */
    public $data;

    public function __construct(Horse $horse, User $user, $notification, array $data)
    {
        $this->horse = $horse;
        $this->user = $user;
        $this->notification = $notification;
        $this->data = $data;
    }
}
