<?php

namespace HorseStories\Models\Horses;

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
        return $this->horse->where('slug', $slug)->firstOrFail();
    }

    /**
     * @param string $value
     * @return \HorseStories\Models\Horses\Horse[]
     */
    public function search($value)
    {
        return $this->horse->where('name', 'like', '%' . $value . '%')->get();
    }
}
