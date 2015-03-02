<?php 
namespace HorseStories\Models\Statuses;
  
use HorseStories\Models\Users\User;

class StatusRepository
{
    /**
     * @param \HorseStories\Models\Users\User $user
     * @return mixed
     */
    public function getAllForUser(User $user)
    {
        return $user->statuses()->with('horse')->latest()->get();
    }
}