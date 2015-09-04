<?php
namespace EQM\Http\Controllers\Statuses;

use EQM\Events\CommentWasPosted;
use EQM\Models\Comments\CommentRepository;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\StatusRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use Input;

class CommentController extends Controller
{
    /**
     * @var \EQM\Models\Comments\CommentRepository
     */
    private $comments;

    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @param \EQM\Models\Comments\CommentRepository $comments
     * @param \Illuminate\Auth\AuthManager $auth
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     */
    public function __construct(CommentRepository $comments, AuthManager $auth, StatusRepository $statuses)
    {
        $this->comments = $comments;
        $this->auth = $auth;
        $this->statuses = $statuses;
    }

    /**
     * @param int $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($status)
    {
        $status = $this->statuses->findById($status);

        $comment = $this->comments->create($status, $this->auth->user(), Input::get('body'));

        $data = ['sender' => $this->auth->user()->fullName(), 'horse' => $status->horse->name];

        event(new CommentWasPosted($comment->status(), $this->auth->user(), Notification::COMMENT_POSTED, $data));

        session()->put('success', 'Your comment was posted');

        return response()->json('success', 200);
    }
}
