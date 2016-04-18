<?php
namespace EQM\Models\Statuses;

use EQM\Models\Users\User;

class StatusPolicy
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Statuses\Status $status
     * @return bool
     */
    public function authorize(User $user, Status $status)
    {
        if ($status instanceof HorseStatus) {
            return $user->isInHorseTeam($status->horse());
        }

        if ($status instanceof CompanyStatus) {
            return $user->isCompanyAdmin($status->company());
        }
    }
}
