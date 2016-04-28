<?php
namespace EQM\Http\Controllers\Admin;

use EQM\Models\Advertising\Advertisements\AdvertisementRepository;
use EQM\Models\Comments\CommentRepository;
use EQM\Models\Companies\CompanyRepository;
use EQM\Models\Conversations\ConversationRepository;
use EQM\Models\Horses\HorseRepository;
use EQM\Models\Invites\FriendInvitesRepository;
use EQM\Models\Pedigrees\PedigreeRepository;
use EQM\Models\Pictures\PictureRepository;
use EQM\Models\Searches\SearchRepository;
use EQM\Models\Statuses\Likes\LikeRepository;
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

    /**
     * @var \EQM\Models\Invites\FriendInvitesRepository
     */
    private $invites;

    /**
     * @var \EQM\Models\Comments\CommentRepository
     */
    private $comments;

    /**
     * @var \EQM\Models\Statuses\Likes\LikeRepository
     */
    private $likes;

    /**
     * @var \EQM\Models\Advertising\Advertisements\AdvertisementRepository
     */
    private $advertisements;

    /**
     * @var \EQM\Models\Companies\CompanyRepository
     */
    private $companies;

    public function __construct(
        UserRepository $users,
        StatusRepository $statuses,
        PedigreeRepository $pedigrees,
        HorseRepository $horses,
        SearchRepository $searches,
        PictureRepository $pictures,
        ConversationRepository $conversations,
        FriendInvitesRepository $invites,
        CommentRepository $comments,
        LikeRepository $likes,
        AdvertisementRepository $advertisements,
        CompanyRepository $companies
    ) {
        $this->users = $users;
        $this->statuses = $statuses;
        $this->pedigrees = $pedigrees;
        $this->horses = $horses;
        $this->searches = $searches;
        $this->pictures = $pictures;
        $this->conversations = $conversations;
        $this->invites = $invites;
        $this->comments = $comments;
        $this->likes = $likes;
        $this->advertisements = $advertisements;
        $this->companies = $companies;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->users->count();
        $unactivatedUsers = $this->users->countUnactivatedUsers();
        $statuses = $this->statuses->count();
        $pedigrees = $this->pedigrees->count();
        $horses = $this->horses->count();
        $searchResults = $this->searches->count();
        $pictures = $this->pictures->count();
        $conversations = $this->conversations->count();
        $invites = $this->invites->count();
        $comments = $this->comments->count();
        $likes = $this->likes->count();
        $advertisements = $this->advertisements->count();
        $companies = $this->companies->count();

        return view('admin.dashboard', compact(
            'users', 'statuses', 'pedigrees', 'horses', 'searchResults', 'pictures', 'conversations', 'invites', 'comments',
            'likes', 'unactivatedUsers', 'advertisements', 'companies'
        ));
    }
}
