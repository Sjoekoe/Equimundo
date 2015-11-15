<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Follows\FollowsRepository;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;
use Input;

class FollowsController extends Controller
{
    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Follows\FollowsRepository
     */
    private $follows;

    /**
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Follows\FollowsRepository $follows
     */
    public function __construct(HorseRepository $horses, FollowsRepository $follows)
    {
        $this->horses = $horses;
        $this->follows = $follows;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\View\View
     */
    public function index(Horse $horse)
    {
        $followers = $this->follows->findForHorse($horse);

        return view('follows.index', compact('horse', 'followers'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $horse = $this->horses->findById(Input::get('horseIdToFollow'));

        $this->authorize('follow-horse', $horse);

        auth()->user()->follow($horse);

        session()->put('success', 'You are now following ' . $horse->name());

        return redirect()->back();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Horse $horse)
    {
        $this->authorize('unfollow-horse', $horse);

        auth()->user()->unFollow($horse);

        session()->put('succes', 'You are no longer following ' . $horse->name());

        return redirect()->back();
    }
}
