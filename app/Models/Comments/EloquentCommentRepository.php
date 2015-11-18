<?php
namespace EQM\Models\Comments;

use EQM\Models\Statuses\Status;
use EQM\Models\Users\User;

class EloquentCommentRepository implements CommentRepository
{
    /**
     * @var \EQM\Models\Comments\Comment
     */
    private $comment;

    /**
     * @param \EQM\Models\Comments\Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Comments\Comment
     */
    public function findById($id)
    {
        return $this->comment->where('id', $id)->firstOrFail();
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @param \EQM\Models\Users\User $user
     * @param string $body
     * @return \EQM\Models\Comments\Comment
     */
    public function create(Status $status, User $user, $body)
    {
        $comment = new EloquentComment();
        $comment->status_id = $status->id();
        $comment->body = $body;
        $comment->user_id = $user->id;

        $comment->save();

        return $comment;
    }

    /**
     * @param \EQM\Models\Comments\Comment $comment
     * @param string $body
     * @return \EQM\Models\Comments\Comment
     */
    public function update(Comment $comment, $body)
    {
        $comment->body = $body;
        $comment->save();

        return $comment;
    }

    /**
     * @param \EQM\Models\Comments\Comment $comment
     */
    public function delete(Comment $comment)
    {
        $comment->delete();
    }
}
