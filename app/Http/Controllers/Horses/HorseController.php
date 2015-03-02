<?php 
namespace HorseStories\Http\Controllers\Horses;

use Auth;
use Flash;
use HorseStories\Http\Requests\CreateHorse;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Horses\HorseCreator;
use Illuminate\Routing\Controller;

class HorseController extends Controller
{

    /**
     * @var \HorseStories\Models\Horses\HorseCreator
     */
    private $horseCreator;

    public function __construct(HorseCreator $horseCreator)
    {
        $this->horseCreator = $horseCreator;
    }

    public function index()
    {
        return view('horses.index');
    }

    public function create()
    {
        return view('horses.create');
    }

    public function store(CreateHorse $request)
    {
        $horse = $this->horseCreator->create(Auth::user(), $request->all());

        Flash::success($horse->name . ' was successfully created.');

        return redirect()->route('horses.index');
    }

    public function show($slug)
    {
        $horse = Horse::where('slug', '=', $slug)->with('statuses')->firstOrFail();

        return view('horses.show', compact('horse'));
    }
}