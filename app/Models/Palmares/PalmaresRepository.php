<?php
namespace HorseStories\Models\Palmares;

use HorseStories\Models\Horses\Horse;

class PalmaresRepository
{
    /**
     * @var \HorseStories\Models\Palmares\Palmares
     */
    private $palmares;

    /**
     * @param \HorseStories\Models\Palmares\Palmares $palmares
     */
    public function __construct(Palmares $palmares)
    {
        $this->palmares = $palmares;
    }

    /**
     * @param int $id
     * @return \HorseStories\Models\Palmares\Palmares
     */
    public function findById($id)
    {
        return $this->palmares->findOrFail($id);
    }

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @return \HorseStories\Models\Palmares\Palmares[]
     */
    public function getPalmaresForHorse(Horse $horse)
    {
        return $this->palmares->with('event')->where('horse_id', $horse->id)->orderBy('date', 'desc')->get();
    }
}
