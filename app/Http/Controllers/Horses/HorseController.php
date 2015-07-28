<?php
namespace EQM\Http\Controllers\Horses;

use Auth;
use DB;
use EQM\Core\Files\Uploader;
use EQM\Events\HorseWasCreated;
use EQM\Http\Requests\CreateHorse;
use EQM\Http\Requests\UpdateHorse;
use EQM\Models\Horses\HorseCreator;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Horses\HorseUpdater;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\User;
use Illuminate\Routing\Controller;
use Request;
use Session;

class HorseController extends Controller
{
    /**
     * @var \EQM\Models\Horses\HorseCreator
     */
    private $horseCreator;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \EQM\Models\Horses\HorseUpdater
     */
    private $horseUpdater;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @param \EQM\Models\Horses\HorseCreator $horseCreator
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Horses\HorseUpdater $horseUpdater
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Statuses\StatusRepository $statuses
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
     * @param \EQM\Http\Requests\CreateHorse $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateHorse $request)
    {
        $horse = $this->horseCreator->create($request->all());

        if (Request::hasFile('profile_pic')) {
            $this->uploader->uploadPicture(Request::file('profile_pic'), $horse, true);
        }

        event(new HorseWasCreated($horse));

        Session::put('success', $horse->name . ' was successfully created.');

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
     * @param \EQM\Http\Requests\UpdateHorse $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($slug, UpdateHorse $request)
    {
        $horse = $this->initHorse($slug);

        $this->horseUpdater->update($horse, $request->all());

        Session::put('success', $horse->name . ' was updated');

        return redirect()->route('horses.show', $horse->slug);
    }

    /**
     * @param int $horseId
     * @return \EQM\Models\Horses\Horse
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
