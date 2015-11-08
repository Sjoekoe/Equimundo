<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Events\PalmaresWasCreated;
use EQM\Events\PalmaresWasDeleted;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Palmares\PalmaresRepository;
use Input;

class PalmaresController extends Controller
{
    /**
     * @var \EQM\Models\Palmares\PalmaresRepository
     */
    private $palmaresRepository;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \EQM\Models\Palmares\PalmaresRepository $palmaresRepository
     * @param \EQM\Models\Horses\HorseRepository $horses
     */
    public function __construct(
        PalmaresRepository $palmaresRepository,
        HorseRepository $horses
    ) {
        $this->palmaresRepository = $palmaresRepository;
        $this->horses = $horses;
    }

    /**
     * @param string $horseSlug
     * @return \Illuminate\View\View
     */
    public function index($horseSlug)
    {
        $horse = $this->initHorse($horseSlug);

        $palmaresResults = $this->palmaresRepository->findPalmaresForHorse($horse);

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

        event(new PalmaresWasCreated($horse, Input::all()));

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

        $this->palmaresRepository->update($palmares, Input::all());

        $horse = $palmares->horse();

        return redirect()->route('palmares.index', $horse->slug);
    }

    /**
     * @param int $palmaresId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($palmaresId)
    {
        $palmares = $this->initPalmares($palmaresId);

        $horse = $palmares->horse();

        event(new PalmaresWasDeleted($palmares));

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

        $horse = $palmares->horse();

        if (! auth()->user()->isInHorseTeam($horse)) {
            abort(403);
        }

        return $palmares;
    }
}
