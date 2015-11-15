<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Events\PalmaresWasCreated;
use EQM\Events\PalmaresWasDeleted;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Palmares\Palmares;
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
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\View\View
     */
    public function index(Horse $horse)
    {
        $palmaresResults = $this->palmaresRepository->findPalmaresForHorse($horse);

        return view('horses.palmares.index', compact('horse', 'palmaresResults'));
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\View\View
     */
    public function create(Horse $horse)
    {
        $this->authorize('create-palmares', $horse);

        return view('horses.palmares.create', compact('horse'));
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Horse $horse)
    {
        $this->authorize('create-palmares', $horse);

        event(new PalmaresWasCreated($horse, Input::all()));

        return redirect()->route('palmares.index', $horse->slug());
    }

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
     * @return \Illuminate\View\View
     */
    public function edit(Palmares $palmares)
    {
        $this->authorize('edit-palmares', $palmares->horse());

        return view('horses.palmares.edit', compact('palmares'));
    }

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Palmares $palmares)
    {
        $this->authorize('edit-palmares', $palmares->horse());

        $this->palmaresRepository->update($palmares, Input::all());

        $horse = $palmares->horse();

        return redirect()->route('palmares.index', $horse->slug());
    }

    /**
     * @param \EQM\Models\Palmares\Palmares $palmares
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Palmares $palmares)
    {
        $horse = $palmares->horse();

        $this->authorize('delete-palmares', $horse);

        event(new PalmaresWasDeleted($palmares));

        return redirect()->route('palmares.index', $horse->slug());
    }
}
