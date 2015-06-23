<?php
namespace HorseStories\Models\Pedigrees;

use DateTime;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Horses\HorseRepository;

class PedigreeCreator
{
    /**
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \HorseStories\Models\Horses\HorseRepository $horses
     */
    public function __construct(HorseRepository $horses)
    {
        $this->horses = $horses;
    }

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param array $values
     */
    public function create(Horse $horse, $values)
    {
        $pedigree = new Pedigree();

        $pedigree->horse_id = $horse->id;
        $pedigree->type = $values['type'];

        if ($values['life_number'] && $family = $this->horses->findByLifeNumber($values['life_number'])) {
            $pedigree = $this->createFamilyTree($family, $pedigree);
        } else {
            $pedigree->family_name = $values['name'];
            $pedigree->family_life_number = $values['life_number'];
            $pedigree->color = $values['color'];
            $pedigree->height = $values['height'];
            $pedigree->breed = $values['breed'];

            if ($values['date_of_birth']) {
                $pedigree->date_of_birth = new DateTime($values['date_of_birth']);
            }

            if ($values['date_of_death']) {
                $pedigree->date_of_death = new DateTime($values['date_of_death']);
            }
        }

        $pedigree->save();
    }

    /**
     * @param \HorseStories\Models\Horses\Horse $family
     * @param \HorseStories\Models\Pedigrees\Pedigree $pedigree
     * @return \HorseStories\Models\Pedigrees\Pedigree
     */
    private function createFamilyTree(Horse $family, Pedigree $pedigree)
    {
        $pedigree->family_name = $family->name;
        $pedigree->family_life_number = $family->life_number;
        $pedigree->color = $family->color;
        $pedigree->height = $family->height;
        $pedigree->breed = $family->breed;
        $pedigree->date_of_birth = $family->date_of_birth;
        $pedigree->family_id = $family->id;

        return $pedigree;
    }
}