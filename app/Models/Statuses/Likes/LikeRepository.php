<?php
namespace EQM\Models\Statuses\Likes;

use EQM\Models\Users\User;

interface LikeRepository
{
    /**
     * @param \EQM\Models\Users\User $user
     * @return array
     */
    public function findForUser(User $user);

    /**
     * @return int
     */
    public function count();
}
