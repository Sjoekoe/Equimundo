<?php
namespace EQM\Models\Follows;

use EQM\Models\Horses\Horse;

interface FollowsRepository
{
    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return mixed
     */
    public function findForHorse(Horse $horse);
}
