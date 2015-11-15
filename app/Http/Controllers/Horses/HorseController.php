<?php
namespace EQM\Http\Controllers\Horses;

use DB;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseCreator;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Horses\HorseUpdater;
use EQM\Models\Horses\Requests\CreateHorse;
use EQM\Models\Horses\Requests\UpdateHorse;
use EQM\Models\HorseTeams\HorseTeamRepository;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\User;

class HorseController extends Controller
{

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
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\HorseTeams\HorseTeamRepository $horseTeams
     */
    public function __construct(
        HorseRepository $horses,
        StatusRepository $statuses,
        HorseTeamRepository $horseTeams
    ) {
        $this->horses = $horses;
        $this->statuses = $statuses;
        $this->horseTeams = $horseTeams;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \Illuminate\View\View
     */
    public function index(User $user)
    {
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

        session()->put('success', $horse->name() . ' was successfully created.');

        return redirect()->route('horses.index', auth()->user()->id);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\View\View
     */
    public function show(Horse $horse)
    {
        $statuses = $this->statuses->findFeedForHorse($horse);

        $likes = DB::table('likes')->whereUserId(auth()->user()->id)->lists('status_id');

        return view('horses.show', compact('horse', 'likes', 'statuses'));
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\View\View
     */
    public function edit(Horse $horse)
    {
        $this->authorize('edit-horse', $horse);

        $disciplines = trans('disciplines.list');

        return view('horses.edit', compact('horse', 'disciplines'));
    }

    /**
     * @param \EQM\Models\Horses\Requests\UpdateHorse $request
     * @param \EQM\Models\Horses\HorseUpdater $updater
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateHorse $request, HorseUpdater $updater, Horse $horse)
    {
        $this->authorize('edit-horse', $horse);

        $updater->update($horse, $request->all());

        session(['success', $horse->name() . ' was updated']);

        return redirect()->route('horses.edit', $horse->slug());
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Horse $horse)
    {
        $this->authorize('delete-horse', $horse);

        $this->horseTeams->delete();

        session()->put('success', 'The horse was removed from your list');

        return redirect()->route('home');
    }
}
