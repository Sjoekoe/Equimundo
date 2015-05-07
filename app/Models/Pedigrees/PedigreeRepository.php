<?php
namespace HorseStories\Models\Pedigrees;

use HorseStories\Models\Horses\Horse;

class PedigreeRepository
{
    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param int $type
     * @return \HorseStories\Models\Pedigrees\Pedigree|null
     */
    public function findExistingPedigree(Horse $horse, $type)
    {
        return Pedigree::where('horse_id', $horse->id)->where('type', $type)->first();
    }
}