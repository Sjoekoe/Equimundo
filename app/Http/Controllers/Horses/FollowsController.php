<?php
namespace EQM\Http\Controllers\Horses;

use EQM\Models\Follows\FollowsRepository;
use EQM\Models\Horses\HorseRepository;
use Illuminate\Routing\Controller;
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
     * @param string $horseSlug
     * @return \Illuminate\View\View
     */
    public function index($horseSlug)
    {
        $horse = $this->horses->findBySlug($horseSlug);

        $followers = $this->follows->findForHorse($horse);

        return view('follows.index', compact('horse', 'followers'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $horse = $this->horses->findById(Input::get('horseIdToFollow'));

        auth()->user()->follow($horse);

        session()->put('success', 'You are now following ' . $horse->name);

        return redirect()->back();
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $horse = $this->horseRepository->findById($id);

        auth()->user()->unFollow($horse);

        session()->put('succes', 'You are no longer following ' . $horse->name);

        return redirect()->back();
    }
}
