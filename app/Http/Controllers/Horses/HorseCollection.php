<?php
namespace EQM\Http\Controllers\Horses;

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
            $result[$horse->id()] = $horse->name();
        }

        return $result;
    }
}
