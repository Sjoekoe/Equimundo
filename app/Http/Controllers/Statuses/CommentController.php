<?php
namespace EQM\Http\Controllers\Statuses;

use Auth;
use EQM\Events\CommentWasPosted;
use EQM\Models\Comments\CommentCreator;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\Status;
use Illuminate\Routing\Controller;
use Input;
use Session;

class CommentController extends Controller
{
    /**
     * @var \EQM\Models\Comments\CommentCreator
     */
    private $commentCreator;

    /**
     * @param \EQM\Models\Comments\CommentCreator $commentCreator
     */
    public function __construct(CommentCreator $commentCreator)
    {
        $this->commentCreator = $commentCreator;
    }

    /**
     * @param int $status
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($status)
    {
        $status = Status::findOrFail($status);

        $comment = $this->commentCreator->create($status, Input::get('body'));

        $data = ['sender' => Auth::user()->fullName(), 'horse' => $status->horse->name];

        event(new CommentWasPosted($comment->status, Auth::user(), Notification::COMMENT_POSTED, $data));

        Session::put('success', 'Your comment was posted');

        return response()->json('success', 200);
    }
}
