<?php
namespace EQM\Http\Controllers\Pages;

use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\HorseCollection;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Statuses\Likes\LikeRepository;
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
     * @var \EQM\Models\Statuses\Likes\LikeRepository
     */
    private $likes;

    public function __construct(
        StatusRepository $statuses,
        HorseRepository $horses,
        HorseCollection $collection,
        LikeRepository $likes
    ) {
        $this->statuses = $statuses;
        $this->horses = $horses;
        $this->collection = $collection;
        $this->likes = $likes;
    }

    public function home()
    {
        if (auth()->check()) {
            $horses = $this->collection->getIdAndNamePairs($this->horses->findForUser(auth()->user()));
            $statuses = $this->statuses->findFeedForUser(auth()->user());
            $likes = $this->likes->findForUser(auth()->user());
        }

        return view('pages.home', compact('horses', 'statuses', 'likes'));
    }
}
