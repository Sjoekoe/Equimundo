<?php
namespace EQM\Api\Statuses;

use EQM\Api\Comments\CommentTransformer;
use EQM\Api\Horses\HorseTransformer;
use EQM\Api\Users\UserTransformer;
use EQM\Models\Statuses\Status;
use League\Fractal\TransformerAbstract;

class StatusTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'horse',
        'comments',
        'likes',
    ];

    public function transform(Status $status)
    {
        return [
            'id' => $status->id(),
            'body' => $status->body(),
            'like_count' => count($status->likes()),
            'created_at' => $status->createdAt()->toIso8601String(),
            'prefix' => $status->prefix() ? trans('statuses.prefixes.' . $status->prefix()) : null,
            'liked_by_user' => auth()->check() ? $status->isLikedByUser(auth()->user()) : false,
            'picture' => $status->hasPicture() ? route('file.picture', [$status->getPicture()->id()]) : null,
            'can_delete_status' => auth()->check() ? auth()->user()->can('delete-status', $status) : false,
        ];
    }

    public function includeHorse(Status $status)
    {
        return $this->item($status->horse(), new HorseTransformer());
    }

    public function includeComments(Status $status)
    {
        return $this->collection($status->comments(), new CommentTransformer());
    }

    public function includeLikes(Status $status)
    {
        return count($status->likes()) ? $this->collection($status->likes(), new UserTransformer()) : null;
    }
}
