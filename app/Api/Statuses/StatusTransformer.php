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
            'prefix' => $status->prefix(),
        ];
    }

    public function includeHorse(Status $status)
    {
        return $this->item($status->horse(), new HorseTransformer());
    }

    public function includeComments(Status $status)
    {
        return count($status->comments()) ? $this->collection($status->comments(), new CommentTransformer()) : null;
    }

    public function includeLikes(Status $status)
    {
        return count($status->likes()) ? $this->collection($status->likes(), new UserTransformer()) : null;
    }
}
