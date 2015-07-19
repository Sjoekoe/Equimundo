<?php
namespace HorseStories\Http\Controllers\Statuses;

use Auth;
use HorseStories\Events\CommentWasPosted;
use HorseStories\Models\Comments\CommentCreator;
use HorseStories\Models\Notifications\Notification;
use HorseStories\Models\Statuses\Status;
use Illuminate\Routing\Controller;
use Input;
use Session;

class CommentController extends Controller
{
    /**
     * @var \HorseStories\Models\Comments\CommentCreator
     */
    private $commentCreator;

    /**
     * @param \HorseStories\Models\Comments\CommentCreator $commentCreator
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

        $data = ['sender' => Auth::user()->username, 'horse' => $status->horse->name];

        event(new CommentWasPosted($comment->status, Auth::user(), Notification::COMMENT_POSTED, $data));

        Session::put('success', 'Your comment was posted');

        return response()->json('success', 200);
    }
}
