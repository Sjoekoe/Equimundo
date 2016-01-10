<?php
namespace EQM\Events;

use EQM\Models\Comments\Comment;
use EQM\Models\Users\User;
use Illuminate\Queue\SerializesModels;

class CommentWasLiked extends Event
{
    use SerializesModels;

    /**
     * @var \EQM\Models\Comments\Comment
     */
    public $comment;

    /**
     * @var \EQM\Models\Users\User
     */
    public $user;

    /**
     * @var int
     */
    public $notification;

    /**
     * @var array
     */
    public $data;

    /**
     * CommentLiked constructor.
     *
     * @param \EQM\Models\Comments\Comment $comment
     * @param \EQM\Models\Users\User $user
     * @param int $notification
     * @param array $data
     */
    public function __construct(Comment $comment, User $user, $notification, array $data)
    {
        $this->comment = $comment;
        $this->user = $user;
        $this->notification = $notification;
        $this->data = $data;
    }
}
