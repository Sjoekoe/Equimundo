<?php
namespace EQM\Models\Invites;

interface FriendInvites
{
    const TABLE = 'friend_invites';

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function email();

    /**
     * @return \EQM\Models\Users\User
     */
    public function user();
}
