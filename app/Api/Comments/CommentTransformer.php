<?php
namespace EQM\Api\Comments;

use EQM\Api\Users\UserTransformer;
use EQM\Models\Comments\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'user',
        'likes'
    ];

    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id(),
            'body' => $comment->body(),
            'like_count' =>count($comment->likes()),
        ];
    }

    public function includeUser(Comment $comment)
    {
        return $this->item($comment->poster(), new UserTransformer());
    }

    public function includeLikes(Comment $comment)
    {
        return count($comment->likes()) ? $this->collection($comment->likes(), new UserTransformer()) : null;
    }
}
