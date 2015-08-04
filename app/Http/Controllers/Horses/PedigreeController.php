<?php
namespace EQM\Http\Controllers\Horses;

use Auth;
use EQM\Http\Requests\CreateFamilyMember;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Pedigrees\PedigreeCreator;
use EQM\Models\Pedigrees\PedigreeRepository;
use EQM\Models\Pedigrees\PedigreeUpdater;
use Illuminate\Routing\Controller;

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
     * @var \EQM\Models\Pedigrees\PedigreeUpdater
     */
    private $updater;

    /**
     * @param \EQM\Models\Pedigrees\PedigreeCreator $pedigreeCreator
     * @param \EQM\Models\Pedigrees\PedigreeRepository $pedigrees
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Pedigrees\PedigreeUpdater $updater
     */
    public function __construct(
        PedigreeCreator $pedigreeCreator,
        PedigreeRepository $pedigrees,
        HorseRepository $horses,
        PedigreeUpdater $updater
    ) {
        $this->pedigreeCreator = $pedigreeCreator;
        $this->pedigrees = $pedigrees;
        $this->horses = $horses;
        $this->updater = $updater;
    }

    /**
     * @param string $horseSlug
     * @return \Illuminate\View\View
     */
    public function index($horseSlug)
    {
        $horse = $this->horses->findBySlug($horseSlug);

        return view('horses.pedigree.index', compact('horse'));
    }

    /**
     * @param string $horseSlug
     * @return \Illuminate\View\View
     */
    public function create($horseSlug)
    {
        $horse = $this->initHorse($horseSlug);

        return view('horses.pedigree.create', compact('horse'));
    }

    /**
     * @param string $horseSlug
     * @param \EQM\Http\Requests\CreateFamilyMember $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($horseSlug, CreateFamilyMember $request)
    {
        $horse = $this->initHorse($horseSlug);

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
     * @param int $pedigreeId
     * @return \Illuminate\View\View
     */
    public function edit($pedigreeId)
    {
        $pedigree = $this->initPedigree($pedigreeId);

        $horse = $pedigree->horse;

        return view('horses.pedigree.edit', compact('pedigree', 'horse'));
    }

    /**
     * @param int $pedigreeId
     * @param \EQM\Http\Requests\CreateFamilyMember $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($pedigreeId, CreateFamilyMember $request)
    {
        $pedigree = $this->initPedigree($pedigreeId);

        $this->updater->update($pedigree, $request->all());

        return redirect()->route('pedigree.index', $pedigree->horse->slug);
    }

    /**
     * @param int $pedigreeId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($pedigreeId)
    {
        $pedigree = $this->initPedigree($pedigreeId);

        $horse = $pedigree->horse;

        $pedigree->delete();

        return redirect()->route('pedigree.index', $horse->slug);
    }

    /**
     * @param $horseSlug
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function initHorse($horseSlug)
    {
        $horse = $this->horses->findBySlug($horseSlug);

        if ($this->userHasPermission($horse)) {
            return $horse;
        }

        abort(403);

    }

    /**
     * @param int $pedigreeId
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    private function initPedigree($pedigreeId)
    {
        $pedigree = $this->pedigrees->findById($pedigreeId);

        if ($this->userHasPermission($pedigree->horse)) {
            return $pedigree;
        }

        abort(403);
    }

    /**
     * @param int $horse
     * @return bool
     */
    private function userHasPermission($horse)
    {
        return Auth::user()->isHorseOwner($horse);
    }
}
