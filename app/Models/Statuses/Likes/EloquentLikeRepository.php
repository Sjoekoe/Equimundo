<?php
namespace EQM\Models\Statuses\Likes;

use DB;
use EQM\Models\Users\User;

class EloquentLikeRepository implements LikeRepository
{
    /**
     * @param \EQM\Models\Users\User $user
     * @return array
     */
    public function findForUser(User $user)
    {
        return DB::table('likes')->whereUserId($user->id())->lists('status_id');
    }
}
