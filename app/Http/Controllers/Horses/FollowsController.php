<?php
namespace HorseStories\Http\Controllers\Horses;

use Auth;
use HorseStories\Models\Follows\FollowsRepository;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Horses\HorseRepository;
use Illuminate\Routing\Controller;
use Input;
use Redirect;
use Session;

class FollowsController extends Controller
{
    /**
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horseRepository;

    /**
     * @var \HorseStories\Models\Follows\FollowsRepository
     */
    private $followsRepository;

    /**
     * @param \HorseStories\Models\Horses\HorseRepository $horseRepository
     * @param \HorseStories\Models\Follows\FollowsRepository $followsRepository
     */
    public function __construct(HorseRepository $horseRepository, FollowsRepository $followsRepository)
    {
        $this->horseRepository = $horseRepository;
        $this->followsRepository = $followsRepository;
    }

    public function index($horseSlug)
    {
        $horse = Horse::where('slug', $horseSlug)->firstOrFail();

        $followers = $this->followsRepository->findForHorse($horse);

        return view('follows.index', compact('horse', 'followers'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $horse = $this->horseRepository->findById(Input::get('horseIdToFollow'));

        Auth::user()->follow($horse);

        Session::put('success', 'You are now following ' . $horse->name);

        return redirect()->back();
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $horse = $this->horseRepository->findById($id);

        Auth::user()->unFollow($horse);

        Session::put('succes', 'You are no longer following ' . $horse->name);

        return Redirect::back();
    }
}
