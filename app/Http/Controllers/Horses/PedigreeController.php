<?php
namespace EQM\Http\Controllers\Horses;

use Carbon\Carbon;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Pedigrees\Pedigree;
use EQM\Models\Pedigrees\PedigreeCreator;
use EQM\Models\Pedigrees\PedigreeRepository;
use EQM\Models\Pedigrees\Requests\CreateFamilyMember;
use Illuminate\Http\Request;

class PedigreeController extends Controller
{
    /**
     * @var \EQM\Models\Pedigrees\PedigreeCreator
     */
    private $pedigreeCreator;

    /**
     * @var \EQM\Models\Pedigrees\PedigreeRepository
     */
    private $pedigrees;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    public function __construct(
        PedigreeCreator $pedigreeCreator,
        PedigreeRepository $pedigrees,
        HorseRepository $horses
    ) {
        $this->pedigreeCreator = $pedigreeCreator;
        $this->pedigrees = $pedigrees;
        $this->horses = $horses;
    }

    public function index(Horse $horse)
    {
        return view('horses.pedigree.index', compact('horse'));
    }

    public function create(Horse $horse)
    {
        $this->authorize('create-pedigree', $horse);

        return view('horses.pedigree.create', compact('horse'));
    }

    public function store(CreateFamilyMember $request, Horse $horse)
    {
        $this->authorize('create-pedigree', $horse);

        if ($this->alReadyHasSpecificFamilyConnection($horse, $request)) {
            return back();
        }

        if ($request->has('life_number')) {
            if ($this->relativeHasSpecificFamilyConnection($horse, $request->get('life_number'), $request)) {
                return back();
            }

            if ($this->isIncorrectGender($request->get('life_number'), $request->get('type'))) {
                return back();
            }
        }

        if ($this->hasIncorrectAges($horse, $request)) {
            return back();
        }

        $values = $this->generateGender($request->all());

        $this->pedigreeCreator->create($horse, $values);

        return redirect()->route('pedigree.index', $horse->slug);
    }

    public function delete(Pedigree $pedigree)
    {
        $horse = $pedigree->horse();

        $this->authorize('delete-pedigree', $horse);

        $this->pedigrees->delete($pedigree);

        return redirect()->route('pedigree.index', $horse->slug());
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    private function alReadyHasSpecificFamilyConnection(Horse $horse, Request $request)
    {
        $type = $request->get('type');
        $message = '';

        if ($type == Pedigree::FATHER && $horse->hasFather()) {
            $message = $horse->name() . ' already has a father defined.';
        }

        if ($type == Pedigree::MOTHER && $horse->hasMother()) {
            $message = $horse->name() . ' already has a mother defined.';
        }

        if ($message !== '') {
            session()->put('error', $message);

            return true;
        }

        return false;
    }

    /**
     * @param string $lifeNumber
     * @param int $type
     * @return bool
     */
    private function isIncorrectGender($lifeNumber, $type)
    {
        if ($this->horses->findByLifeNumber($lifeNumber) !== null) {
            $horse = $this->horses->findByLifeNumber($lifeNumber);

            if (($type == Pedigree::MOTHER || $type == Pedigree::DAUGHTER) && ! $horse->isFemale()) {
                session()->put('error', 'The family you wanted to enter is not female in our records');

                return true;
            }

            if (($type == Pedigree::FATHER || $type == Pedigree::SON) && $horse->isFemale()) {
                session()->put('error', 'The family you wanted to enter is not a male in our records');

                return true;
            }
        }

        return false;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    private function hasIncorrectAges(Horse $horse, Request $request)
    {
        $dateOfBirth = null;

        if ($request->has('life_number')) {
            if ($this->horses->findByLifeNumber($request->get('life_number')) !== null) {
                $relative = $this->horses->findByLifeNumber($request->get('life_number'));
                $dateOfBirth = $relative->dateOfBirth();
            }
        }

        if (! $dateOfBirth && $request->has('date_of_birth')) {
            $dateOfBirth = Carbon::createFromFormat('Y', $request->get('date_of_birth'));
        }

        if ($dateOfBirth) {
            return $this->ageDifference($horse, $request, $dateOfBirth);
        }

        return false;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \Illuminate\Http\Request $request
     * @param \DateTime $dateOfBirth
     * @return bool
     */
    private function ageDifference(Horse $horse, Request $request, $dateOfBirth)
    {
        return ($request->get('type') == Pedigree::DAUGHTER) || ($request->get('type') == Pedigree::SON)
            ? $dateOfBirth < $horse->dateOfBirth()
            : $dateOfBirth > $horse->dateOfBirth();
    }

    /**
     * @param array $values
     * @return array
     */
    private function generateGender(array $values)
    {
        if (array_key_exists('life_number', $values) && $values['life_number'] !== '') {
            if ($horse = $this->horses->findByLifeNumber($values['life_number'])) {
                $values['gender'] = $horse->gender();
            } else {
                $values = $this->generateGenderByType($values);
            }
        } else {
            $values = $this->generateGenderByType($values);
        }

        return $values;
    }

    /**
     * @param array $values
     * @return array
     */
    private function generateGenderByType(array $values)
    {
        if ($values['type'] == Pedigree::MOTHER ||
            $values['type'] == Pedigree::DAUGHTER ||
            $values['type'] == Pedigree::FATHERSMOTHER ||
            $values['type'] == Pedigree::MOTHERSMOTHER
        ) {
            $values['gender'] = Horse::MARE;
        } else {
            $values['gender'] = Horse::STALLION;
        }

        return $values;
    }

    private function relativeHasSpecificFamilyConnection(Horse $horse, $lifeNumber, $request)
    {
        if ($this->horses->findByLifeNumber($lifeNumber) !== null) {
            $family = $this->horses->findByLifeNumber($lifeNumber);

            if (($horse->gender() == Horse::MARE) && $family->hasMother() && ($request->get('type') == Pedigree::DAUGHTER || ($request->get('type') == Pedigree::SON))) {
                return true;
            }

            if (($horse->gender() !== Horse::MARE) && $family->hasFather() && ($request->get('type') == Pedigree::DAUGHTER || ($request->get('type') == Pedigree::SON))) {
                return true;
            }
        }

        return false;
    }
}
