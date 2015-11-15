<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Pedigrees\Pedigree;
use EQM\Models\Pedigrees\PedigreeCreator;
use EQM\Models\Pedigrees\PedigreeRepository;
use EQM\Models\Pedigrees\Requests\CreateFamilyMember;

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

    /**
     * @param \EQM\Models\Pedigrees\PedigreeCreator $pedigreeCreator
     * @param \EQM\Models\Pedigrees\PedigreeRepository $pedigrees
     * @param \EQM\Models\Horses\HorseRepository $horses
     */
    public function __construct(
        PedigreeCreator $pedigreeCreator,
        PedigreeRepository $pedigrees,
        HorseRepository $horses
    ) {
        $this->pedigreeCreator = $pedigreeCreator;
        $this->pedigrees = $pedigrees;
        $this->horses = $horses;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\View\View
     */
    public function index(Horse $horse)
    {
        return view('horses.pedigree.index', compact('horse'));
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\View\View
     */
    public function create(Horse $horse)
    {
        $this->authorize('create-pedigree', $horse);

        return view('horses.pedigree.create', compact('horse'));
    }

    /**
     * @param \EQM\Models\Pedigrees\Requests\CreateFamilyMember $request
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateFamilyMember $request, Horse $horse)
    {
        $this->authorize('create-pedigree', $horse);

        if ($request->get('type') < 7) {
            $pedigree = $this->pedigrees->findExistingPedigree($horse, $request->get('type'));

            if ($pedigree) {
                return redirect()->back();
            }
        }

        $this->pedigreeCreator->create($horse, $request->all());

        return redirect()->route('pedigree.index', $horse->slug);
    }

    /**
     * @param \EQM\Models\Pedigrees\Pedigree $pedigree
     * @return \Illuminate\View\View
     */
    public function edit(Pedigree $pedigree)
    {
        $horse = $pedigree->horse();

        $this->authorize('edit-pedigree', $horse);

        return view('horses.pedigree.edit', compact('pedigree', 'horse'));
    }

    /**
     * @param \EQM\Models\Pedigrees\Requests\CreateFamilyMember $request
     * @param \EQM\Models\Pedigrees\Pedigree $pedigree
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CreateFamilyMember $request, Pedigree $pedigree)
    {
        $this->authorize('edit-pedigree', $pedigree->horse());

        $this->pedigrees->update($pedigree, $request->all());

        return redirect()->route('pedigree.index', $pedigree->horse()->slug());
    }

    /**
     * @param \EQM\Models\Pedigrees\Pedigree $pedigree
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Pedigree $pedigree)
    {
        $horse = $pedigree->horse();

        $this->authorize('delete-pedigree', $horse);

        $this->pedigrees->delete($pedigree);

        return redirect()->route('pedigree.index', $horse->slug());
    }
}
