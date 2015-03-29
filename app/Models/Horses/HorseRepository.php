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
}