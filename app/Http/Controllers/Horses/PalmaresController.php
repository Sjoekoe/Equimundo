<?php
namespace HorseStories\Http\Controllers\Horses;

use HorseStories\Http\Controllers\Controller;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Palmares\PalmaresCreator;
use Input;

class PalmaresController extends Controller
{
    /**
     * @var \HorseStories\Models\Palmares\PalmaresCreator
     */
    private $palmaresCreator;

    /**
     * @param \HorseStories\Models\Palmares\PalmaresCreator $palmaresCreator
     */
    public function __construct(PalmaresCreator $palmaresCreator)
    {
        $this->palmaresCreator = $palmaresCreator;
    }

    /**
     * @param string $horseSlug
     * @return \Illuminate\View\View
     */
    public function index($horseSlug)
    {
        $horse = $this->initHorse($horseSlug);

        return view('horses.palmares.index', compact('horse'));
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