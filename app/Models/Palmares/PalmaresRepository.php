<?php
namespace EQM\Models\Palmares;

use EQM\Models\Horses\Horse;

class PalmaresRepository
{
    /**
     * @var \EQM\Models\Palmares\Palmares
     */
    private $palmares;

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
     */
    public function __construct(Palmares $palmares)
    {
        $this->palmares = $palmares;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Palmares\Palmares
     */
    public function findById($id)
    {
        return $this->palmares->findOrFail($id);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Palmares\Palmares[]
     */
    public function getPalmaresForHorse(Horse $horse)
    {
        return $this->palmares->with('event')->where('horse_id', $horse->id)->orderBy('date', 'desc')->get();
    }
}
