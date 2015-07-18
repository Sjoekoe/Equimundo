<?php

namespace HorseStories\Models\Horses;

use HorseStories\Models\Users\User;

class HorseRepository
{
    /**
     * @var \HorseStories\Models\Horses\Horse
     */
    private $horse;

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     */
    public function __construct(Horse $horse)
    {
        $this->horse = $horse;
    }

    /**
     * @param $id
     * @return \HorseStories\Models\Horses\Horse
     */
    public function findById($id)
    {
           return $this->horse->findOrFail($id);
    }

    /**
     * @param string $lifeNumber
     * @return \HorseStories\Models\Horses\Horse|null
     */
    public function findByLifeNumber($lifeNumber)
    {
        return $this->horse->where('life_number', $lifeNumber)->first();
    }

    /**
     * @param string $slug
     * @return \HorseStories\Models\Horses\Horse
     */
    public function findBySlug($slug)
    {
        return $this->horse->where('slug', $slug)->whereNotNull('user_id')->firstOrFail();
    }

    /**
     * @param string $value
     * @return \HorseStories\Models\Horses\Horse[]
     */
    public function search($value)
    {
        return $this->horse->where('name', 'like', '%' . $value . '%')->get();
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return array
     */
    public function findHorsesForSelect(User $user)
    {
        return $this->horse->with('statuses')->where('user_id', $user->id)->lists('name', 'id');
    }
}
