<?php
namespace HorseStories\Http\Controllers\Horses;

use Auth;
use HorseStories\Http\Controllers\Controller;
use HorseStories\Models\Horses\HorseRepository;
use HorseStories\Models\Palmares\PalmaresCreator;
use HorseStories\Models\Palmares\PalmaresDeleter;
use HorseStories\Models\Palmares\PalmaresRepository;
use HorseStories\Models\Palmares\PalmaresUpdater;
use Input;

class PalmaresController extends Controller
{
    /**
     * @var \HorseStories\Models\Palmares\PalmaresCreator
     */
    private $palmaresCreator;

    /**
     * @var \HorseStories\Models\Palmares\PalmaresRepository
     */
    private $palmaresRepository;

    /**
     * @var \HorseStories\Models\Palmares\PalmaresUpdater
     */
    private $updater;

    /**
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \HorseStories\Models\Palmares\PalmaresDeleter
     */
    private $deleter;

    /**
     * @param \HorseStories\Models\Palmares\PalmaresCreator $palmaresCreator
     * @param \HorseStories\Models\Palmares\PalmaresRepository $palmaresRepository
     * @param \HorseStories\Models\Palmares\PalmaresUpdater $updater
     * @param \HorseStories\Models\Horses\HorseRepository $horses
     * @param \HorseStories\Models\Palmares\PalmaresDeleter $deleter
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
     * @return \HorseStories\Models\Horses\Horse
     */
    private function initHorse($horseSlug)
    {
        $horse = $this->horses->findBySlug($horseSlug);

        return $horse;
    }

    /**
     * @param int $palmaresId
     * @return \HorseStories\Models\Palmares\Palmares
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
