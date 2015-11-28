<?php
namespace EQM\Models\Horses;

use Illuminate\Support\Collection;

class HorseCollection
{
    /**
     * @param \Illuminate\Support\Collection $horses
     * @return array
     */
    public function getIdAndNamePairs(Collection $horses)
    {
        $result = [];

        foreach ($horses as $horse) {
            $result[$horse->horse_id] = $horse->name();
        }

        return $result;
    }
}
