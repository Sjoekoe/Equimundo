<?php
namespace EQM\Models\Users;

class EloquentUserInterestRepository implements UserInterestRepository
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param int $type
     */
    public function create(User $user, $type)
    {
        $interest = new EloquentUserInterests();
        $interest->user_id = $user->id();
        $interest->type = $type;

        $interest->save();
    }
}
