<?php
namespace EQM\Api\Comments;

use EQM\Api\Users\UserTransformer;
use EQM\Models\Comments\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user',
    ];

    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id(),
            'body' => $comment->body(),
        ];
    }

    public function includeUser(Comment $comment)
    {
        return $this->item($comment->poster(), new UserTransformer());
    }
}
