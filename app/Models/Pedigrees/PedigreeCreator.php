<?php
namespace HorseStories\Models\Pedigrees;

use DateTime;
use HorseStories\Events\PedigreeWasCreated;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Horses\HorseCreator;
use HorseStories\Models\Horses\HorseRepository;
use HorseStories\Models\Notifications\Notification;

class PedigreeCreator
{
    /**
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \HorseStories\Models\Horses\HorseCreator
     */
    private $horseCreator;

    /**
     * @var \HorseStories\Models\Pedigrees\PedigreeConnector
     */
    private $pedigreeConnector;

    /**
     * @param \HorseStories\Models\Horses\HorseRepository $horses
     * @param \HorseStories\Models\Horses\HorseCreator $horseCreator
     * @param \HorseStories\Models\Pedigrees\PedigreeConnector $pedigreeConnector
     */
    public function __construct(HorseRepository $horses, HorseCreator $horseCreator, PedigreeConnector $pedigreeConnector)
    {
        $this->horses = $horses;
        $this->horseCreator = $horseCreator;
        $this->pedigreeConnector = $pedigreeConnector;
    }

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param array $values
     */
    public function create(Horse $horse, $values)
    {
        if ($values['type'] == 5 || $values['type'] ==  6) {
            $horse = $horse->father();

            $values['type'] == 5 ? $values['type'] = 1 : $values['type'] = 2;
        } elseif ($values['type'] == 7 || $values['type'] == 8 ) {
            $horse = $horse->mother();

            $values['type'] == 7 ? $values['type'] = 1 : $values['type'] = 2;
        }

        $family = $this->createFamilyConnection($horse, $values);

        $this->createPedigree($horse, $family, $values['type']);

        $data = ['family' => $horse->name, 'horse' => $family->name];

        event(new PedigreeWasCreated($horse, $family, Notification::PEDIGREE_CREATED, $data));
    }

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param array $values
     * @return \HorseStories\Models\Horses\Horse|null
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
     * @param \HorseStories\Models\Horses\Horse $horse
     * @param \HorseStories\Models\Horses\Horse $family
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
