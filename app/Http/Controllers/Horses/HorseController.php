<?php
namespace EQM\Http\Controllers\Horses;

use DB;
use EQM\Core\Files\Uploader;
use EQM\Models\Horses\HorseCreator;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Horses\HorseUpdater;
use EQM\Models\Horses\Requests\CreateHorse;
use EQM\Models\Horses\Requests\UpdateHorse;
use EQM\Models\HorseTeams\HorseTeamRepository;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\UserRepository;
use Illuminate\Routing\Controller;

class HorseController extends Controller
{
    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\HorseTeams\HorseTeamRepository
     */
    private $horseTeams;
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\HorseTeams\HorseTeamRepository $horseTeams
     * @param \EQM\Models\Users\UserRepository $users
     */
    public function __construct(
        Uploader $uploader,
        HorseRepository $horses,
        StatusRepository $statuses,
        HorseTeamRepository $horseTeams,
        UserRepository $users
    ) {
        $this->uploader = $uploader;
        $this->horses = $horses;
        $this->statuses = $statuses;
        $this->horseTeams = $horseTeams;
        $this->users = $users;
    }

    /**
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function index($userId)
    {
        $user = $this->users->findById($userId);

        $horses = $this->horses->findForUser($user);

        return view('horses.index', compact('user', 'horses'));
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
     * @param \EQM\Models\Horses\Requests\CreateHorse $request
     * @param \EQM\Models\Horses\HorseCreator $creator
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateHorse $request, HorseCreator $creator)
    {
        $horse = $creator->create(auth()->user(), $request->all());

        session()->put('success', $horse->name . ' was successfully created.');

        return redirect()->route('horses.index', auth()->user()->id);
    }

    /**
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $horse = $this->horses->findBySlug($slug);

        $statuses = $this->statuses->findFeedForHorse($horse);

        $likes = DB::table('likes')->whereUserId(auth()->user()->id)->lists('status_id');

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
     * @param \EQM\Models\Horses\Requests\UpdateHorse $request
     * @param \EQM\Models\Horses\HorseUpdater $updater
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateHorse $request, HorseUpdater $updater, $slug)
    {
        $horse = $this->initHorse($slug);

        $updater->update($horse, $request->all());

        session(['success', $horse->name() . ' was updated']);

        return redirect()->route('horses.edit', $horse->slug());
    }

    /**
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($slug)
    {
        $horse = $this->initHorse($slug);

        $this->horseTeams->delete();

        session()->put('success', 'The horse was removed from your list');

        return redirect()->route('home');
    }

    /**
     * @param string $slug
     * @return \EQM\Models\Horses\Horse
     */
    private function initHorse($slug)
    {
        $horse = $this->horses->findBySlug($slug);

        if (auth()->user()->isInHorseTeam($horse)) {
            return $horse;
        }

        abort(403);
    }
}
