<?php
namespace HorseStories\Models\Users;

use HorseStories\Models\Horses\Horse;

class UserRepository
{
    /**
     * @param int $id
     * @return \HorseStories\Models\Users\User
     */
    public function findById($id)
    {
        return User::where('id', $id)->firstOrFail();
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return array
     */
    public function findHorsesForSelect(User $user)
    {
        return Horse::with('statuses')->where('user_id', $user->id)->lists('name', 'id');
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findConversations(User $user)
    {
        return User::find($user->id)->conversations()->orderBy('updated_at', 'DESC')->where('deleted_at', null)->get();
    }

    /**
     * @return \HorseStories\Models\Users\User[]
     */
    public function all()
    {
        return User::all();
    }
}
