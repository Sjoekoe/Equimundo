<?php 
namespace HorseStories\Http\Controllers\Horses;

use Auth;
use Flash;
use HorseStories\Models\Horses\HorseRepository;
use Illuminate\Routing\Controller;
use Input;
use Redirect;

class FollowsController extends Controller
{
    /**
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horseRepository;

    /**
     * @param \HorseStories\Models\Horses\HorseRepository $horseRepository
     */
    public function __construct(HorseRepository $horseRepository)
    {
        $this->horseRepository = $horseRepository;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $horse = $this->horseRepository->findById(Input::get('horseIdToFollow'));

        Auth::user()->follow($horse);

        Flash::success('You are now following ' . $horse->name);

        return Redirect::back();
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $horse = $this->horseRepository->findById($id);

        Auth::user()->unFollow($horse);

        Flash::success('You are no longer following ' . $horse->name);

        return Redirect::back();
    }
}