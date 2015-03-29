<?php 
namespace HorseStories\Http\Controllers\Pages;

use Auth;
use HorseStories\Http\Controllers\Controller;
use HorseStories\Models\Statuses\StatusRepository;
use HorseStories\Models\Users\UserRepository;

class PagesController extends Controller
{

    /**
     * @var \HorseStories\Models\Users\UserRepository
     */
    private $users;
    /**
     * @var \HorseStories\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @param \HorseStories\Models\Users\UserRepository $users
     * @param \HorseStories\Models\Statuses\StatusRepository $statuses
     */
    public function __construct(UserRepository $users, StatusRepository $statuses)
    {
        $this->users = $users;
        $this->statuses = $statuses;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        if (Auth::check()) {
            $horses = $this->users->findHorsesForSelect(Auth::user());
            if (count($horses)) {
                $statuses = $this->statuses->getFeedForUser(Auth::user());
            } else {
                $statuses = [];
            }
        }

        return view('pages.home', compact('horses', 'statuses'));
    }
}