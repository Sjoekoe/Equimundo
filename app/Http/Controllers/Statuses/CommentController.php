<?php
namespace EQM\Http\Controllers\Statuses;

use EQM\Events\CommentWasPosted;
use EQM\Models\Comments\CommentRepository;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\StatusRepository;
use Illuminate\Routing\Controller;
use Input;

class CommentController extends Controller
{
    /**
     * @var \EQM\Models\Comments\CommentRepository
     */
    private $comments;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @param \EQM\Models\Comments\CommentRepository $comments
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     */
    public function __construct(CommentRepository $comments, StatusRepository $statuses)
    {
        $this->comments = $comments;
        $this->statuses = $statuses;
    }

    /**
     * @param int $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($status)
    {
        $status = $this->statuses->findById($status);

        $comment = $this->comments->create($status, auth()->user(), Input::get('body'));

        $data = ['sender' => auth()->user()->fullName(), 'horse' => $status->horse()->name];

        event(new CommentWasPosted($comment->status(), auth()->user(), Notification::COMMENT_POSTED, $data));

        session()->put('success', 'Your comment was posted');

        return response()->json('success', 200);
    }
}
