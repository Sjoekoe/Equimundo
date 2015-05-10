<?php
namespace HorseStories\Models\Follows;

use HorseStories\Models\Horses\Horse;

class FollowsRepository
{
    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findForHorse(Horse $horse)
    {
        return $horse->followers()->get();
    }
}