<?php

namespace EQM\Models\Horses;

use EQM\Models\Users\User;

class HorseRepository
{
    /**
     * @var \EQM\Models\Horses\Horse
     */
    private $horse;

    /**
     * @param \EQM\Models\Horses\Horse $horse
     */
    public function __construct(Horse $horse)
    {
        $this->horse = $horse;
    }

    /**
     * @param $id
     * @return \EQM\Models\Horses\Horse
     */
    public function findById($id)
    {
           return $this->horse->findOrFail($id);
    }

    /**
     * @param string $lifeNumber
     * @return \EQM\Models\Horses\Horse|null
     */
    public function findByLifeNumber($lifeNumber)
    {
        return $this->horse->where('life_number', $lifeNumber)->first();
    }

    /**
     * @param string $slug
     * @return \EQM\Models\Horses\Horse
     */
    public function findBySlug($slug)
    {
        return $this->horse->where('slug', $slug)->whereNotNull('user_id')->firstOrFail();
    }

    /**
     * @param string $value
     * @return \EQM\Models\Horses\Horse[]
     */
    public function search($value)
    {
        return $this->horse->where('name', 'like', '%' . $value . '%')->get();
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return array
     */
    public function findHorsesForSelect(User $user)
    {
        return $this->horse->with('statuses')->where('user_id', $user->id)->lists('name', 'id')->all();
    }
}
