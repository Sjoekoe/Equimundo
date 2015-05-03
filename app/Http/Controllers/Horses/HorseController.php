<?php 
namespace HorseStories\Http\Controllers\Horses;

use Auth;
use DB;
use Flash;
use HorseStories\Core\Files\Uploader;
use HorseStories\Http\Requests\CreateHorse;
use HorseStories\Http\Requests\UpdateHorse;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Horses\HorseCreator;
use HorseStories\Models\Horses\HorseUpdater;
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
     * @var \HorseStories\Models\Horses\HorseUpdater
     */
    private $horseUpdater;

    /**
     * @param \HorseStories\Models\Horses\HorseCreator $horseCreator
     * @param \HorseStories\Core\Files\Uploader $uploader
     * @param \HorseStories\Models\Horses\HorseUpdater $horseUpdater
     */
    public function __construct(HorseCreator $horseCreator, Uploader $uploader, HorseUpdater $horseUpdater)
    {
        $this->horseCreator = $horseCreator;
        $this->uploader = $uploader;
        $this->horseUpdater = $horseUpdater;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('horses.index');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('horses.create');
    }

    /**
     * @param \HorseStories\Http\Requests\CreateHorse $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateHorse $request)
    {
        $horse = $this->horseCreator->create(Auth::user(), $request->all());

        if (Request::hasFile('profile_pic')) {
            $this->uploader->uploadPicture(Request::file('profile_pic'), $horse, true);
        }

        Flash::success($horse->name . ' was successfully created.');

        return redirect()->route('horses.index');
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $horse = Horse::where('slug', '=', $slug)->with('statuses')->firstOrFail();

        $likes = DB::table('likes')->whereUserId(Auth::user()->id)->lists('status_id');

        return view('horses.show', compact('horse', 'likes'));
    }

    /**
     * @param int $horseId
     * @return \Illuminate\View\View
     */
    public function edit($horseId)
    {
        $horse = $this->initHorse($horseId);

        return view('horses.edit', compact('horse'));
    }

    /**
     * @param int $horseId
     * @param \HorseStories\Http\Requests\UpdateHorse $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($horseId, UpdateHorse $request)
    {
        $horse = $this->initHorse($horseId);

        $this->horseUpdater->update($horse, $request->all());

        Flash::success($horse->name  . ' was updated');

        return redirect()->route('horses.show', $horse->slug);
    }

    /**
     * @param int $horseId
     * @return \HorseStories\Models\Horses\Horse
     */
    private function initHorse($horseId)
    {
        $horse = Horse::findOrFail($horseId);

        if ($horse->owner()->first()->id !== Auth::user()->id) {
            abort(403);
        }

        return $horse;
    }
}