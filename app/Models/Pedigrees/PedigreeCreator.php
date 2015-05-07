<?php
namespace HorseStories\Models\Pedigrees;

use DateTime;
use HorseStories\Models\Horses\Horse;

class PedigreeCreator
{
    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param array $values
     */
    public function create(Horse $horse, $values)
    {
        $pedigree = new Pedigree();

        $pedigree->horse_id = $horse->id;
        $pedigree->type = $values['type'];
        $pedigree->family_name = $values['name'];
        $pedigree->family_life_number = $values['life_number'];

        if ($values['date_of_birth']) {
            $pedigree->date_of_birth = new DateTime($values['date_of_birth']);
        }

        if ($values['date_of_death']) {
            $pedigree->date_of_death = new DateTime($values['date_of_death']);
        }

        $pedigree->save();
    }
}