<?php
namespace EQM\Models\Comments;

use EQM\Events\CommentWasPosted;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\HorseStatus;
use EQM\Models\Statuses\Status;
use EQM\Models\Users\User;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;

class CommentCreator
{
    /**
     * @var \EQM\Models\Comments\CommentRepository
     */
    private $comments;
    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    private $dispatcher;

    /**
     * @param \EQM\Models\Comments\CommentRepository $comments
     * @param \Illuminate\Contracts\Events\Dispatcher $dispatcher
     */
    public function __construct(CommentRepository $comments, Dispatcher $dispatcher)
    {
        $this->comments = $comments;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @param \EQM\Models\Users\User $user
     * @param \Illuminate\Http\Request $request
     * @return \EQM\Models\Comments\Comment
     */
    public function create(Status $status, User $user, Request $request)
    {
        $comment = $this->comments->create($status, $user, $request->get('body'));

        if ($status instanceof HorseStatus) {
            $data = ['sender' => $user->fullName(), 'horse' => $status->horse()->name()];

            $this->dispatcher->fire(new CommentWasPosted($comment->status(), auth()->user(), Notification::COMMENT_POSTED, $data));
        }

        return $comment;
    }
}
