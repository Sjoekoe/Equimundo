<?php
namespace EQM\Http\Controllers\Horses;

use Auth;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Palmares\PalmaresCreator;
use EQM\Models\Palmares\PalmaresDeleter;
use EQM\Models\Palmares\PalmaresRepository;
use EQM\Models\Palmares\PalmaresUpdater;
use Input;

class PalmaresController extends Controller
{
    /**
     * @var \EQM\Models\Palmares\PalmaresCreator
     */
    private $palmaresCreator;

    /**
     * @var \EQM\Models\Palmares\PalmaresRepository
     */
    private $palmaresRepository;

    /**
     * @var \EQM\Models\Palmares\PalmaresUpdater
     */
    private $updater;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Palmares\PalmaresDeleter
     */
    private $deleter;

    /**
     * @param \EQM\Models\Palmares\PalmaresCreator $palmaresCreator
     * @param \EQM\Models\Palmares\PalmaresRepository $palmaresRepository
     * @param \EQM\Models\Palmares\PalmaresUpdater $updater
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Palmares\PalmaresDeleter $deleter
     */
    public function __construct(
        PalmaresCreator $palmaresCreator,
        PalmaresRepository $palmaresRepository,
        PalmaresUpdater $updater,
        HorseRepository $horses,
        PalmaresDeleter $deleter
    ) {
        $this->palmaresCreator = $palmaresCreator;
        $this->palmaresRepository = $palmaresRepository;
        $this->updater = $updater;
        $this->horses = $horses;
        $this->deleter = $deleter;
    }

    /**
     * @param string $horseSlug
     * @return \Illuminate\View\View
     */
    public function index($horseSlug)
    {
        $horse = $this->initHorse($horseSlug);

        $palmaresResults = $this->palmaresRepository->getPalmaresForHorse($horse);

        return view('horses.palmares.index', compact('horse', 'palmaresResults'));
    }

    /**
     * @param string $horseSlug
     * @return \Illuminate\View\View
     */
    public function create($horseSlug)
    {
        $horse = $this->initHorse($horseSlug);

        return view('horses.palmares.create', compact('horse'));
    }

    /**
     * @param string $horseSlug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($horseSlug)
    {
        $horse = $this->initHorse($horseSlug);

        $this->palmaresCreator->create($horse, Input::all());

        return redirect()->route('palmares.index', $horse->slug);
    }

    /**
     * @param int $palmaresId
     * @return \Illuminate\View\View
     */
    public function edit($palmaresId)
    {
        $palmares = $this->initPalmares($palmaresId);

        return view('horses.palmares.edit', compact('palmares'));
    }

    /**
     * @param int $palmaresId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($palmaresId)
    {
        $palmares = $this->initPalmares($palmaresId);

        $this->updater->update($palmares, Input::all());

        $horse = $palmares->horse;

        return redirect()->route('palmares.index', $horse->slug);
    }

    /**
     * @param int $palmaresId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($palmaresId)
    {
        $palmares = $this->initPalmares($palmaresId);

        $horse = $palmares->horse;

        $this->deleter->delete($palmares);

        return redirect()->route('palmares.index', $horse->slug);
    }

    /**
     * @param string horseSlug
     * @return \EQM\Models\Horses\Horse
     */
    private function initHorse($horseSlug)
    {
        $horse = $this->horses->findBySlug($horseSlug);

        return $horse;
    }

    /**
     * @param int $palmaresId
     * @return \EQM\Models\Palmares\Palmares
     */
    private function initPalmares($palmaresId)
    {
        $palmares = $this->palmaresRepository->findById($palmaresId);

        $horse = $palmares->horse;

        if (! Auth::user()->isHorseOwner($horse)) {
            abort(403);
        }

        return $palmares;
    }
}
