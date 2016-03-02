<?php
namespace EQM\Http\Controllers\Pages;

use EQM\Http\Controllers\Controller;
use EQM\Models\Horses\HorseCollection;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Statuses\Likes\LikeRepository;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\UserRepository;
use Queue;

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

    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    public function __construct(
        StatusRepository $statuses,
        HorseRepository $horses,
        HorseCollection $collection,
        LikeRepository $likes,
        UserRepository $users
    ) {
        $this->statuses = $statuses;
        $this->horses = $horses;
        $this->collection = $collection;
        $this->likes = $likes;
        $this->users = $users;
    }

    public function home()
    {
        $horses = $this->collection->getIdAndNamePairs($this->horses->findForUser(auth()->user()));
        $statuses = $this->statuses->findFeedForUser(auth()->user());
        $likes = $this->likes->findForUser(auth()->user());

        if (count($horses)) {
            $firstHorse = $this->horses->findById(key($horses));
            $initialPicture = $firstHorse->getProfilePicture() ? route('file.picture', $firstHorse->getProfilePicture()->id()) : asset('images/eqm.png');
        } else {
            $initialPicture = asset('images/eqm.png');
        }

        if (! count($statuses)) {
            $popularHorses = $this->horses->findMostPopularHorses();
            $activeHorses = $this->horses->findMostActiveHorses();
            $latestUsers = $this->users->getLatest(auth()->user());
        }

        $latestHorses = $this->horses->latestHorse();

        return view('pages.home', compact('horses', 'statuses', 'likes', 'initialPicture', 'latestUsers', 'popularHorses', 'activeHorses', 'latestHorses'));
    }

    public function terms()
    {
        return view('pages.tos');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function queue()
    {
        return Queue::marshal();
    }

    public function secret()
    {
        Mail::queue('emails.reminder', [], function ($m) {
            $m->from('hello@app.com', 'Your Application');

            $m->to('hans@equimundo.com', 'Hans Jonckers')->subject('Your Reminder!');
        });
    }
}
