<?php
namespace HorseStories\Http\Controllers\Pages;

use Auth;
use DB;
use HorseStories\Http\Controllers\Controller;
use HorseStories\Models\Horses\HorseRepository;
use HorseStories\Models\Statuses\StatusRepository;

class PagesController extends Controller
{
    /**
     * @var \HorseStories\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \HorseStories\Models\Users\UserRepository $users
     * @param \HorseStories\Models\Statuses\StatusRepository $statuses
     * @param \HorseStories\Models\Horses\HorseRepository $horses
     */
    public function __construct(StatusRepository $statuses, HorseRepository $horses)
    {
        $this->statuses = $statuses;
        $this->horses = $horses;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        if (Auth::check()) {
            $horses = $this->horses->findHorsesForSelect(Auth::user());
            if (count($horses)) {
                $statuses = $this->statuses->getFeedForUser(Auth::user());
                $likes = DB::table('likes')->whereUserId(Auth::user()->id)->lists('status_id');
            } else {
                $statuses = [];
            }
        }

        return view('pages.home', compact('horses', 'statuses', 'likes'));
    }
}
