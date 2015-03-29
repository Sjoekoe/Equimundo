<?php 
namespace HorseStories\Models\Statuses;
  
use HorseStories\Models\Users\User;

class StatusRepository
{
    /**
     * @param \HorseStories\Models\Users\User $user
     * @return \HorseStories\Models\Statuses\Status[]
     */
    public function getAllForUser(User $user)
    {
        return $user->statuses()->with('horse')->latest()->get();
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return \HorseStories\Models\Statuses\Status[]
     */
    public function getFeedForUser(User $user)
    {
        $horseIds = $user->follows()->lists('horse_id');

        $horseIds[] = $user->horses()->lists('id');

        return Status::whereIn('horse_id', $horseIds)->latest()->get();
    }
}