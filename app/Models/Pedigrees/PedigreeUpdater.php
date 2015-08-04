<?php
namespace EQM\Models\Pedigrees;

use DateTime;

class PedigreeUpdater
{
    /**
     * @param \EQM\Models\Pedigrees\Pedigree $pedigree
     * @param array $values
     */
    public function update(Pedigree $pedigree, $values)
    {
        $pedigree->type = $values['type'];
        $pedigree->family_name = $values['name'];
        $pedigree->family_life_number = $values['life_number'];
        $pedigree->color = $values['color'];
        $pedigree->breed = $values['breed'];
        $pedigree->height = $values['height'];

        if ($values['date_of_birth']) {
            $pedigree->date_of_birth = new DateTime($values['date_of_birth']);
        }

        if ($values['date_of_death']) {
            $pedigree->date_of_death = new DateTime($values['date_of_death']);
        }

        $pedigree->save();
    }
}
