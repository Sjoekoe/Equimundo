<?php
namespace EQM\Api\Statuses;

use EQM\Api\Comments\CommentTransformer;
use EQM\Api\Users\UserTransformer;
use EQM\Models\Statuses\Status;
use League\Fractal\TransformerAbstract;

class StatusTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'comments',
        'likes',
    ];

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @return array
     */
    public function transform(Status $status)
    {
        return [
            'id' => $status->id(),
            'body' => $status->body(),
            'like_count' => count($status->likes()->get()),
            'created_at' => $status->createdAt()->toIso8601String(),
            'prefix' => $status->prefix() ? trans('statuses.prefixes.' . $status->prefix()) : null,
            'liked_by_user' => auth()->check() ? $status->isLikedByUser(auth()->user()) : false,
            'picture' => $status->hasPicture() ? route('file.picture', [$status->getPicture()->id()]) : null,
            'can_delete_status' => auth()->check() ? auth()->user()->can('delete-status', $status) : false,
        ];
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @return \League\Fractal\Resource\Collection
     */
    public function includeComments(Status $status)
    {
        return $this->collection($status->comments()->get(), new CommentTransformer());
    }

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @return \League\Fractal\Resource\Collection|null
     */
    public function includeLikes(Status $status)
    {
        return count($status->likes()->get()) ? $this->collection($status->likes()->get(), new UserTransformer()) : null;
    }
}
