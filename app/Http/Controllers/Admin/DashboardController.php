<?php
namespace EQM\Http\Controllers\Admin;

use EQM\Models\Conversations\ConversationRepository;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Pedigrees\PedigreeRepository;
use EQM\Models\Pictures\PictureRepository;
use EQM\Models\Searches\SearchRepository;
use EQM\Models\Statuses\StatusRepository;
use EQM\Models\Users\UserRepository;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\Pedigrees\PedigreeRepository
     */
    private $pedigrees;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Models\Searches\SearchRepository
     */
    private $searches;

    /**
     * @var \EQM\Models\Pictures\PictureRepository
     */
    private $pictures;

    /**
     * @var \EQM\Models\Conversations\ConversationRepository
     */
    private $conversations;

    public function __construct(
        UserRepository $users,
        StatusRepository $statuses,
        PedigreeRepository $pedigrees,
        HorseRepository $horses,
        SearchRepository $searches,
        PictureRepository $pictures,
        ConversationRepository $conversations
    ) {
        $this->users = $users;
        $this->statuses = $statuses;
        $this->pedigrees = $pedigrees;
        $this->horses = $horses;
        $this->searches = $searches;
        $this->pictures = $pictures;
        $this->conversations = $conversations;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->users->count();
        $statuses = $this->statuses->count();
        $pedigrees = $this->pedigrees->count();
        $horses = $this->horses->count();
        $searchResults = $this->searches->count();
        $pictures = $this->pictures->count();
        $conversations = $this->conversations->count();

        return view('admin.dashboard', compact('users', 'statuses', 'pedigrees', 'horses', 'searchResults', 'pictures', 'conversations'));
    }
}
