<?php
namespace EQM\Http\Controllers\Horses;

use Auth;
use DB;
use EQM\Core\Files\Uploader;
use EQM\Events\HorseWasCreated;
use EQM\Http\Requests\CreateHorse;
use EQM\Http\Requests\UpdateHorse;
use EQM\Models\Albums\Album;
use EQM\Models\Horses\HorseCreator;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Horses\HorseUpdater;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\User;
use Illuminate\Auth\AuthManager;
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
     * @var \EQM\Http\Controllers\Horses\AuthManager
     */
    private $auth;

    /**
     * @param \EQM\Models\Horses\HorseCreator $horseCreator
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Horses\HorseUpdater $horseUpdater
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(
        HorseCreator $horseCreator,
        Uploader $uploader,
        HorseUpdater $horseUpdater,
        HorseRepository $horses,
        StatusRepository $statuses,
        AuthManager $auth
    ) {
        $this->horseCreator = $horseCreator;
        $this->uploader = $uploader;
        $this->horseUpdater = $horseUpdater;
        $this->horses = $horses;
        $this->statuses = $statuses;
        $this->auth = $auth;
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
        if ($request->has('life_number') && $horse = $this->horses->findByLifeNumber($request->get('life_number'))) {
            if ($horse->hasOwner()) {
                session(['error', 'This horse already has an owner. If you are the rightful owner, please contact us.']);

                return redirect()->back();
            }

            $horse = $this->horseUpdater->update($horse, $request->all());
            $horse->user_id = $this->auth->user()->id;

            $horse->save();
        } else {
            $horse = $this->horseCreator->create($request->all());
        }

        event(new HorseWasCreated($horse));

        if (Request::hasFile('profile_pic')) {
            $picture = $this->uploader->uploadPicture(Request::file('profile_pic'), $horse, true);

            $picture->addToAlbum($horse->getStandardAlbum(Album::PROFILEPICTURES));
        }

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

        $statuses = $this->statuses->findFeedForHorse($horse);

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

        session(['success', $horse->name . ' was updated']);

        return redirect()->route('horses.show', $horse->slug);
    }

    /**
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($slug)
    {
        $horse = $this->initHorse($slug);

        session(['success', $horse->name . ' was deleted']);

        $horse->delete();

        return redirect()->route('home');
    }

    /**
     * @param string $slug
     * @return \EQM\Models\Horses\Horse
     */
    private function initHorse($slug)
    {
        $horse = $this->horses->findBySlug($slug);

        if ($this->auth->user()->isHorseOwner($horse)) {
            return $horse;
        }

        abort(403);
    }
}
