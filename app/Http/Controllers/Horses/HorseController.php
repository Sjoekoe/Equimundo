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
use HorseStories\Models\Horses\HorseRepository;
use HorseStories\Models\Horses\HorseUpdater;
use HorseStories\Models\Statuses\StatusRepository;
use HorseStories\Models\Users\User;
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
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \HorseStories\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @param \HorseStories\Models\Horses\HorseCreator $horseCreator
     * @param \HorseStories\Core\Files\Uploader $uploader
     * @param \HorseStories\Models\Horses\HorseUpdater $horseUpdater
     * @param \HorseStories\Models\Horses\HorseRepository $horses
     * @param \HorseStories\Models\Statuses\StatusRepository $statuses
     */
    public function __construct(
        HorseCreator $horseCreator,
        Uploader $uploader,
        HorseUpdater $horseUpdater,
        HorseRepository $horses,
        StatusRepository $statuses
    ) {
        $this->horseCreator = $horseCreator;
        $this->uploader = $uploader;
        $this->horseUpdater = $horseUpdater;
        $this->horses = $horses;
        $this->statuses = $statuses;
    }

    /**
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function index($userId)
    {
        $user = User::with('horses')->where('id', $userId)->firstOrFail();

        return view('horses.index', compact('user'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $disciplines = trans('disciplines.list');

        return view('horses.create', compact('disciplines'));
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

        return redirect()->route('horses.index', Auth::user()->id);
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $horse = $this->horses->findBySlug($slug);

        $statuses = $this->statuses->getFeedForHorse($horse);

        $likes = DB::table('likes')->whereUserId(Auth::user()->id)->lists('status_id');

        return view('horses.show', compact('horse', 'likes', 'statuses'));
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function edit($slug)
    {
        $horse = $this->initHorse($slug);

        $disciplines = trans('disciplines.list');

        return view('horses.edit', compact('horse', 'disciplines'));
    }

    /**
     * @param string $slug
     * @param \HorseStories\Http\Requests\UpdateHorse $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($slug, UpdateHorse $request)
    {
        $horse = $this->initHorse($slug);

        $this->horseUpdater->update($horse, $request->all());

        Flash::success($horse->name . ' was updated');

        return redirect()->route('horses.show', $horse->slug);
    }

    /**
     * @param int $horseId
     * @return \HorseStories\Models\Horses\Horse
     */
    private function initHorse($horseId)
    {
        $horse = $this->horses->findBySlug($horseId);

        if ($horse->owner()->first()->id !== Auth::user()->id) {
            abort(403);
        }

        return $horse;
    }
}
