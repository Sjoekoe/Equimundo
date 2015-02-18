<?php 
namespace HorseStories\Models\Users;
  
use HorseStories\Models\Horses\Horse;

class UserRepository
{

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return array
     */
    public function findHorsesForSelect(User $user)
    {
        return Horse::with('statuses')->where('user_id', $user->id)->lists('name', 'id');
    }
}