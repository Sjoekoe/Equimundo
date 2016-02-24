<?php
namespace EQM\Models\Users;

interface UserInterestRepository
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param int $type
     */
    public function create(User $user, $type);
}
