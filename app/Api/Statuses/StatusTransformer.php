<?php
namespace EQM\Api\Statuses;

use EQM\Api\Comments\CommentTransformer;
use EQM\Api\Companies\CompanyTransformer;
use EQM\Api\Horses\HorseTransformer;
use EQM\Api\Users\UserTransformer;
use EQM\Models\Statuses\HorseStatus;
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
        'poster'
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
            'prefix' => $status->prefix() ? trans('statuses.prefixes.' . $status->prefix(), ['link' => $status->prefixLink()]) : null,
            'liked_by_user' => auth()->check() ? $status->isLikedByUser(auth()->user()) : false,
            'picture' => $status->hasPicture() ? route('file.picture', [$status->getPicture()->id()]) : null,
            'can_delete_status' => auth()->check() ? auth()->user()->can('delete-status', $status) : false,
            'is_horse_status' => $status instanceof HorseStatus,
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

    public function includePoster(Status $status)
    {
        if ($status->type() == HorseStatus::TYPE) {
            return $this->item($status->horse(), new HorseTransformer());
        }

        return $this->item($status->company(), new CompanyTransformer());
    }
}
