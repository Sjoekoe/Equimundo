<?php
namespace EQM\Models\Pedigrees;

use DateTime;
use EQM\Events\PedigreeWasCreated;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseCreator;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Notifications\Notification;

class PedigreeCreator
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Horses\HorseCreator
     */
    private $horseCreator;

    /**
     * @var \EQM\Models\Pedigrees\PedigreeConnector
     */
    private $pedigreeConnector;

    /**
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Horses\HorseCreator $horseCreator
     * @param \EQM\Models\Pedigrees\PedigreeConnector $pedigreeConnector
     */
    public function __construct(HorseRepository $horses, HorseCreator $horseCreator, PedigreeConnector $pedigreeConnector)
    {
        $this->horses = $horses;
        $this->horseCreator = $horseCreator;
        $this->pedigreeConnector = $pedigreeConnector;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     */
    public function create(Horse $horse, $values)
    {
        if ($values['type'] == 5 || $values['type'] ==  6) {
            $horse = $horse->father();

            $values['type'] == 5 ? $values['type'] = Pedigree::FATHER : $values['type'] = Pedigree::MOTHER;
        } elseif ($values['type'] == 7 || $values['type'] == 8 ) {
            $horse = $horse->mother();

            $values['type'] == 7 ? $values['type'] = Pedigree::FATHER : $values['type'] = Pedigree::MOTHER;
        }

        $family = $this->createFamilyConnection($horse, $values);

        $this->createPedigree($horse, $family, $values['type']);

        $data = ['family' => $horse->name, 'horse' => $family->name];

        event(new PedigreeWasCreated($horse, $family, Notification::PEDIGREE_CREATED, $data));
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     * @return \EQM\Models\Horses\Horse|null
     */
    private function createFamilyConnection(Horse $horse, $values)
    {
        if ($values['life_number'] && $family = $this->horses->findByLifeNumber($values['life_number'])) {
            $family = $family;
        } else {
            $values ['gender'] = $this->pedigreeConnector->getGender($values['type']);
            $family = $this->horseCreator->create($values, true);
        }

        $values['type'] = $this->pedigreeConnector->getConnection($horse, $values['type']);

        $this->createPedigree($family, $horse, $values['type']);

        return $family;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Models\Horses\Horse $family
     * @param $type
     */
    private function createPedigree(Horse $horse, Horse $family, $type)
    {
        $pedigree = new Pedigree();

        $pedigree->horse_id = $horse->id;
        $pedigree->type = $type;
        $pedigree->family_id = $family->id;

        $pedigree->save();
    }
}
