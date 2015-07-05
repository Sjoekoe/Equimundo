<?php namespace HorseStories\Events;

use HorseStories\Models\Users\User;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Event {

    use SerializesModels;

    /**
     * @var \HorseStories\Events\User
     */
    public $user;

    /**
     * @param \HorseStories\Models\Users\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

}
