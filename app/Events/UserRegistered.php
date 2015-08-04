<?php namespace EQM\Events;

use EQM\Models\Users\User;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Event {

    use SerializesModels;

    /**
     * @var \EQM\Events\User
     */
    public $user;

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

}
