<?php
namespace HorseStories\Http\Controllers\Horses;

use HorseStories\Http\Requests\CreateFamilyMember;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Pedigrees\PedigreeCreator;
use HorseStories\Models\Pedigrees\PedigreeRepository;
use Illuminate\Routing\Controller;

class PedigreeController extends Controller
{
    /**
     * @var \HorseStories\Models\Pedigrees\PedigreeCreator
     */
    private $pedigreeCreator;

    /**
     * @var \HorseStories\Models\Pedigrees\PedigreeRepository
     */
    private $pedigrees;

    /**
     * @param \HorseStories\Models\Pedigrees\PedigreeCreator $pedigreeCreator
     * @param \HorseStories\Models\Pedigrees\PedigreeRepository $pedigrees
     */
    public function __construct(PedigreeCreator $pedigreeCreator, PedigreeRepository $pedigrees)
    {
        $this->pedigreeCreator = $pedigreeCreator;
        $this->pedigrees = $pedigrees;
    }

    /**
     * @param string $horseSlug
     * @return \Illuminate\View\View
     */
    public function index($horseSlug)
    {
        $horse = $this->initHorse($horseSlug);

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
     * @param \HorseStories\Http\Requests\CreateFamilyMember $request
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
     * @param $horseSlug
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function initHorse($horseSlug)
    {
        $horse = Horse::with('pedigree')->where('slug', $horseSlug)->firstOrFail();

        return $horse;
    }
}