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
            'like_count' => count($comment->likes()->get()),
            'created_at' => $comment->createdAt()->toIso8601String(),
            'can_delete_comment' => auth()->check() ? auth()->user()->can('delete-comment', $comment) : false,
            'liked_by_user' => auth()->check() ? $comment->isLikedByUser(auth()->user()) : false,
        ];
    }

    public function includeUser(Comment $comment)
    {
        return $this->item($comment->poster(), new UserTransformer());
    }

    public function includeLikes(Comment $comment)
    {
        return $this->collection($comment->likes()->get(), new UserTransformer());
    }
}
