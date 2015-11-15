<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Events\PalmaresWasCreated;
use EQM\Events\PalmaresWasDeleted;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Palmares\Palmares;
use EQM\Models\Palmares\PalmaresRepository;
use Illuminate\Support\Facades\Request;
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

    public function __construct(PalmaresRepository $palmaresRepository, HorseRepository $horses) {
        $this->palmaresRepository = $palmaresRepository;
        $this->horses = $horses;
    }

    public function index(Horse $horse)
    {
        $palmaresResults = $this->palmaresRepository->findPalmaresForHorse($horse);

        return view('horses.palmares.index', compact('horse', 'palmaresResults'));
    }

    public function create(Horse $horse)
    {
        $this->authorize('create-palmares', $horse);

        return view('horses.palmares.create', compact('horse'));
    }

    // todo add validation
    public function store(Request $request, Horse $horse)
    {
        $this->authorize('create-palmares', $horse);

        // todo refactor this
        event(new PalmaresWasCreated($horse, $request->all()));

        return redirect()->route('palmares.index', $horse->slug());
    }

    public function edit(Palmares $palmares)
    {
        $this->authorize('edit-palmares', $palmares->horse());

        return view('horses.palmares.edit', compact('palmares'));
    }

    public function update(Palmares $palmares)
    {
        $this->authorize('edit-palmares', $palmares->horse());

        $this->palmaresRepository->update($palmares, Input::all());

        $horse = $palmares->horse();

        return redirect()->route('palmares.index', $horse->slug());
    }

    public function delete(Palmares $palmares)
    {
        $horse = $palmares->horse();

        $this->authorize('delete-palmares', $horse);

        event(new PalmaresWasDeleted($palmares));

        return redirect()->route('palmares.index', $horse->slug());
    }
}
