<?php
namespace EQM\Core\JWT;

use EQM\Models\Users\User;

interface TokenGenerator
{
    /**
     * @param \EQM\Models\Users\User $user
     * @return string
     */
    public function byUser(User $user);
}
