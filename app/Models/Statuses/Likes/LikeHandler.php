<?php
namespace EQM\Models\Statuses\Likes;

use EQM\Events\CommentWasLiked;
use EQM\Events\StatusLiked;
use EQM\Models\Comments\Comment;
use EQM\Models\Notifications\Notification;
use EQM\Models\Statuses\Status;
use EQM\Models\Users\User;
use Illuminate\Contracts\Events\Dispatcher;

class LikeHandler
{
    /**
     * @var \EQM\Models\Statuses\Likes\LikeRepository
     */
    private $likes;

    /**
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    private $dispatcher;

    /**
     * @param \EQM\Models\Statuses\Likes\LikeRepository $likes
     * @param \Illuminate\Contracts\Events\Dispatcher $dispatcher
     */
    public function __construct(LikeRepository $likes, Dispatcher $dispatcher)
    {
        $this->likes = $likes;
        $this->dispatcher = $dispatcher;
    }

    public function handleStatus(Status $status, User $user)
    {
        $likes = $this->likes->findForUser($user);

        if (in_array($status->id(), $likes)) {
            $user->likes()->detach($status);
        } else {
            $user->likes()->attach($status);
            $data = ['sender' => $user->fullName(), 'horse' => $status->horse()->name()];

            $this->dispatcher->fire(new StatusLiked($status, $user, Notification::STATUS_LIKED, $data));
        }
    }

    public function handleComment(Comment $comment, User $user)
    {
        if ($comment->isLikedByUser($user)) {
            $user->commentLikes()->detach($comment);
        } else {
            $user->commentLikes()->attach($comment);
            $data = ['liker' => $user->fullName()];

            $this->dispatcher->fire(new CommentWasLiked($comment, $user, Notification::COMMENT_LIKED, $data));
        }
    }
}
