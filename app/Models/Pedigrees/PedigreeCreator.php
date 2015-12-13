<?php
namespace EQM\Models\Pedigrees;

use Carbon\Carbon;
use EQM\Core\Slugs\SlugCreator;
use EQM\Events\PedigreeWasCreated;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseCreator;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Notifications\Notification;
use Illuminate\Auth\AuthManager;

class PedigreeCreator
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Pedigrees\PedigreeConnector
     */
    private $pedigreeConnector;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @var \EQM\Models\Pedigrees\PedigreeRepository
     */
    private $pedigrees;

    /**
     * @var \EQM\Models\Horses\HorseCreator
     */
    private $horseCreator;

    public function __construct(
        HorseRepository $horses,
        PedigreeConnector $pedigreeConnector,
        AuthManager $auth,
        PedigreeRepository $pedigrees,
        SlugCreator $slugCreator,
        HorseCreator $horseCreator
    ) {
        $this->horses = $horses;
        $this->pedigreeConnector = $pedigreeConnector;
        $this->auth = $auth;
        $this->pedigrees = $pedigrees;
        $this->horseCreator = $horseCreator;
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

        $data = ['family' => $horse->name(), 'horse' => $family->name()];

        event(new PedigreeWasCreated($horse, $family, Notification::PEDIGREE_CREATED, $data));
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     * @return \EQM\Models\Horses\Horse|null
     */
    private function createFamilyConnection(Horse $horse, $values)
    {
        if (array_key_exists('life_number', $values)) {
            if ($this->horses->findByLifeNumber($values['life_number'])) {
                $family = $this->horses->findByLifeNumber($values['life_number']);
            } else {
                $family = $this->horseCreator->create(auth()->user(), $values, true);
            }
        } else {
            $values['gender'] = $this->pedigreeConnector->getGender($values['type']);

            if (array_key_exists('date_of_birth', $values) && $values['date_of_birth'] !== '') {
                $values['date_of_birth'] = Carbon::createFromDate($values['date_of_birth'], 0, 0)->format('d/m/Y');
            }

            $family = $this->horseCreator->create(auth()->user(), $values, true);
        }

        $values['type'] = $this->pedigreeConnector->getConnection($horse, $values['type']);

        $this->createPedigree($family, $horse, $values['type']);

        return $family;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Models\Horses\Horse $family
     * @param int $type
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    private function createPedigree(Horse $horse, Horse $family, $type)
    {
        return $this->pedigrees->create($horse, $family, $type);
    }
}
