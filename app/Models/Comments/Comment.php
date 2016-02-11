<?php
namespace EQM\Models\Comments;

use EQM\Models\Users\User;

interface Comment
{
    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function body();

    /**
     * @return \EQM\Models\Users\User
     */
    public function poster();

    /**
     * @return \EQM\Models\Statuses\Status
     */
    public function status();

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function likes();

    /**
     * @param \EQM\Models\Users\User $user
     * @return bool
     */
    public function isLikedByUser(User $user);
}
