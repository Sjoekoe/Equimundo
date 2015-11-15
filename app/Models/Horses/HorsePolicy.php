<?php
namespace EQM\Models\Horses;

use EQM\Models\Users\User;

class HorsePolicy
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Horses\Horse $horse
     * @return bool
     */
    public function horseOwner(User $user, Horse $horse)
    {
        return $user->isInHorseTeam($horse);
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Horses\Horse $horse
     * @return bool
     */
    public function otherUsers(User $user, Horse $horse)
    {
        return ! $user->isInHorseTeam($horse);
    }
}
