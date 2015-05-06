<?php
namespace HorseStories\Http\Controllers\Horses;

use HorseStories\Http\Controllers\Controller;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Palmares\PalmaresCreator;
use HorseStories\Models\Palmares\PalmaresRepository;
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
     * @param \HorseStories\Models\Palmares\PalmaresCreator $palmaresCreator
     * @param \HorseStories\Models\Palmares\PalmaresRepository $palmaresRepository
     */
    public function __construct(PalmaresCreator $palmaresCreator, PalmaresRepository $palmaresRepository)
    {
        $this->palmaresCreator = $palmaresCreator;
        $this->palmaresRepository = $palmaresRepository;
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
     * @param string horseSlug
     * @return \HorseStories\Models\Horses\Horse
     */
    private function initHorse($horseSlug)
    {
        $horse = Horse::where('slug', $horseSlug)->firstOrFail();

        return $horse;
    }
}