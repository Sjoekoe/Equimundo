<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseCreator;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Horses\HorseUpdater;
use EQM\Models\Horses\Requests\CreateHorse;
use EQM\Models\Horses\Requests\UpdateHorse;
use EQM\Models\HorseTeams\HorseTeamRepository;
use EQM\Models\Statuses\Likes\LikeRepository;
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
     * @var \EQM\Models\Statuses\Likes\LikeRepository
     */
    private $likes;

    public function __construct(
        HorseRepository $horses,
        StatusRepository $statuses,
        HorseTeamRepository $horseTeams,
        LikeRepository $likes
    ) {
        $this->horses = $horses;
        $this->statuses = $statuses;
        $this->horseTeams = $horseTeams;
        $this->likes = $likes;
    }

    public function index(User $user)
    {
        $horses = $this->horses->findForUser($user);

        return view('horses.index', compact('user', 'horses'));
    }

    public function create()
    {
        return view('horses.create');
    }

    public function store(CreateHorse $request, HorseCreator $creator)
    {
        $horse = $creator->create(auth()->user(), $request->all());

        session()->put('success', $horse->name() . ' was successfully created.');

        return redirect()->route('home');
    }

    public function show(Horse $horse)
    {
        return view('horses.show', compact('horse'));
    }

    public function edit(Horse $horse)
    {
        $this->authorize('edit-horse', $horse);

        return view('horses.edit', compact('horse'));
    }

    public function update(UpdateHorse $request, HorseUpdater $updater, Horse $horse)
    {
        $this->authorize('edit-horse', $horse);

        $updater->update($horse, $request->all());

        session(['success', $horse->name() . ' was updated']);

        return redirect()->route('horses.edit', $horse->slug());
    }

    public function data(Horse $horse)
    {
        $profilePicturePath = $horse->getProfilePicture() ? route('file.picture', $horse->getProfilePicture()->id()) : asset('images/eqm.png');

        return response()->json($profilePicturePath);
    }
}
