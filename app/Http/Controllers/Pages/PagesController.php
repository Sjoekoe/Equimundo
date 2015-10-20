<?php
namespace EQM\Http\Controllers\Pages;

use Auth;
use DB;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Statuses\StatusRepository;

class PagesController extends Controller
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\Horses\HorseRepository $horses
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
                $statuses = $this->statuses->findFeedForUser(Auth::user());
                $likes = DB::table('likes')->whereUserId(Auth::user()->id)->lists('status_id');
            } else {
                $statuses = [];
            }
        }

        return view('pages.home', compact('horses', 'statuses', 'likes'));
    }
}
