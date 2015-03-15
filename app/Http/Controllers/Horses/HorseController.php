<?php 
namespace HorseStories\Http\Controllers\Horses;

use Auth;
use Flash;
use HorseStories\Core\Files\Uploader;
use HorseStories\Http\Requests\CreateHorse;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Horses\HorseCreator;
use Illuminate\Routing\Controller;
use Request;

class HorseController extends Controller
{

    /**
     * @var \HorseStories\Models\Horses\HorseCreator
     */
    private $horseCreator;
    /**
     * @var \HorseStories\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @param \HorseStories\Models\Horses\HorseCreator $horseCreator
     * @param \HorseStories\Core\Files\Uploader $uploader
     */
    public function __construct(HorseCreator $horseCreator, Uploader $uploader)
    {
        $this->horseCreator = $horseCreator;
        $this->uploader = $uploader;
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

        if (Request::hasFile('profile_pic')) {
            $this->uploader->uploadPicture(Request::file('profile_pic'), $horse, true);
        }

        Flash::success($horse->name . ' was successfully created.');

        return redirect()->route('horses.index');
    }

    public function show($slug)
    {
        $horse = Horse::where('slug', '=', $slug)->with('statuses')->firstOrFail();

        return view('horses.show', compact('horse'));
    }
}