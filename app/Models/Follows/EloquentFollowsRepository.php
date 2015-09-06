<?php
namespace EQM\Models\Follows;

use EQM\Models\Horses\Horse;

class EloquentFollowsRepository implements FollowsRepository
{
    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findForHorse(Horse $horse)
    {
        return $horse->followers()->get();
    }
}
