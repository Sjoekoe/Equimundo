<?php
namespace EQM\Models\Invites;

use EQM\Models\Users\User;

interface FriendInvitesRepository
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param string $email
     * @return \EQM\Models\Invites\FriendInvites
     */
    public function create(User $user, $email);

    /**
     * @return int
     */
    public function count();
}
