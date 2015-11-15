<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Http\Controllers\Controller;
use EQM\Models\Follows\FollowsRepository;
use EQM\Models\Horses\Horse;

class FollowsController extends Controller
{
    /**
     * @var \EQM\Models\Follows\FollowsRepository
     */
    private $follows;

    public function __construct(FollowsRepository $follows)
    {
        $this->follows = $follows;
    }

    public function index(Horse $horse)
    {
        $followers = $this->follows->findForHorse($horse);

        return view('follows.index', compact('horse', 'followers'));
    }

    public function store(Horse $horse)
    {
        $this->authorize('follow-horse', $horse);

        auth()->user()->follow($horse);

        session()->put('success', 'You are now following ' . $horse->name());

        return redirect()->back();
    }

    public function destroy(Horse $horse)
    {
        $this->authorize('unfollow-horse', $horse);

        auth()->user()->unFollow($horse);

        session()->put('succes', 'You are no longer following ' . $horse->name());

        return redirect()->back();
    }
}
