<?php
namespace EQM\Api\Comments;

use EQM\Models\Comments\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id(),
            'body' => $comment->body(),
        ];
    }
}
