<?php
namespace EQM\Models\Invites;

use EQM\Models\Users\User;

class EloquentFriendInvitesRepository implements FriendInvitesRepository
{
    /**
     * @var \EQM\Models\Invites\EloquentFriendInvites
     */
    private $invites;

    public function __construct(EloquentFriendInvites $invites)
    {
        $this->invites = $invites;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param string $email
     * @return \EQM\Models\Invites\FriendInvites
     */
    public function create(User $user, $email)
    {
        $invite = new EloquentFriendInvites();
        $invite->email = $email;
        $invite->user_id = $user->id();

        $invite->save();

        return $invite;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->invites->all());
    }
}
