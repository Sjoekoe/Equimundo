<?php
namespace EQM\Http\Controllers\Horses;

use DB;
use EQM\Core\Files\Uploader;
use EQM\Events\HorseWasCreated;
use EQM\Http\Requests\CreateHorse;
use EQM\Http\Requests\UpdateHorse;
use EQM\Models\Albums\Album;
use EQM\Models\Disciplines\DisciplineRepository;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseCreator;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\HorseTeams\HorseTeamRepository;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\User;
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
     * @var \EQM\Models\Disciplines\DisciplineRepository
     */
    private $disciplines;

    /**
     * @var \EQM\Models\HorseTeams\HorseTeamRepository
     */
    private $horseTeams;

    /**
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\Disciplines\DisciplineRepository $disciplines
     * @param \EQM\Models\HorseTeams\HorseTeamRepository $horseTeams
     */
    public function __construct(
        Uploader $uploader,
        HorseRepository $horses,
        StatusRepository $statuses,
        DisciplineRepository $disciplines,
        HorseTeamRepository $horseTeams
    ) {
        $this->uploader = $uploader;
        $this->horses = $horses;
        $this->statuses = $statuses;
        $this->disciplines = $disciplines;
        $this->horseTeams = $horseTeams;
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
     * @param \EQM\Http\Requests\UpdateHorse $request
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateHorse $request, $slug)
    {
        $horse = $this->initHorse($slug);

        $horse = $this->horses->update($horse, $request->all());

        $this->resolveDisciplines($horse, $request->all());

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

        if (auth()->user()->isHorseOwner($horse)) {
            return $horse;
        }

        abort(403);
    }
}
