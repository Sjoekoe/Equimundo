<?php
namespace EQM\Http\Controllers\Statuses;

use EQM\Events\CommentWasPosted;
use EQM\Models\Comments\Comment;
use EQM\Models\Comments\CommentRepository;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\Status;
use Illuminate\Routing\Controller;
use Input;

class CommentController extends Controller
{
    /**
     * @var \EQM\Models\Comments\CommentRepository
     */
    private $comments;

    /**
     * @param \EQM\Models\Comments\CommentRepository $comments
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     */
    public function __construct(CommentRepository $comments)
    {
        $this->comments = $comments;
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Status $status)
    {
        $comment = $this->comments->create($status, auth()->user(), Input::get('body'));

        $data = ['sender' => auth()->user()->fullName(), 'horse' => $status->horse()->name()];

        event(new CommentWasPosted($comment->status(), auth()->user(), Notification::COMMENT_POSTED, $data));

        session()->put('success', 'Your comment was posted');

        return response()->json('success', 200);
    }

    /**
     * @param \EQM\Models\Comments\Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Comment $comment)
    {
        $this->comments->delete($comment);

        session()->put('success', 'comment deleted');

        return back();
    }
}
