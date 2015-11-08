<?php
namespace EQM\Http\Controllers\Pages;

use DB;
use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\HorseCollection;
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
     * @var \EQM\Models\Horses\HorseCollection
     */
    private $collection;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Models\Horses\HorseCollection $collection
     */
    public function __construct(StatusRepository $statuses, HorseRepository $horses, HorseCollection $collection)
    {
        $this->statuses = $statuses;
        $this->horses = $horses;
        $this->collection = $collection;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function home()
    {
        if (auth()->check()) {
            $horses = $this->collection->getIdAndNamePairs($this->horses->findForUser(auth()->user()));
            if (count($horses)) {
                $statuses = $this->statuses->findFeedForUser(auth()->user());
                $likes = DB::table('likes')->whereUserId(auth()->user()->id)->lists('status_id');
            } else {
                $statuses = [];
            }
        }

        return view('pages.home', compact('horses', 'statuses', 'likes'));
    }
}
