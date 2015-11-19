<?php
namespace EQM\Http\Controllers\Horses;

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

        if ($this->alReadyHasFamilyConnection($horse, $request)) {
            return back();
        }

        $this->pedigreeCreator->create($horse, $request->all());

        return redirect()->route('pedigree.index', $horse->slug);
    }

    public function edit(Pedigree $pedigree)
    {
        $horse = $pedigree->horse();


        return view('horses.pedigree.edit', compact('pedigree', 'horse'));
    }

    public function update(CreateFamilyMember $request, Pedigree $pedigree)
    {
        $this->authorize('edit-pedigree', $pedigree->horse());

        $this->pedigrees->update($pedigree, $request->all());

        return redirect()->route('pedigree.index', $pedigree->horse()->slug());
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
    private function alReadyHasFamilyConnection(Horse $horse, Request $request)
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
}
