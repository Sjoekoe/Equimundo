<?php
namespace EQM\Api\Statuses;

use EQM\Api\Horses\HorseTransformer;
use EQM\Models\Statuses\Status;

class HorseStatusTransformer extends StatusTransformer
{
    protected $defaultIncludes = [
        'horseRelation',
        'comments',
        'likes',
    ];

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeHorseRelation(Status $status)
    {
        return $this->item($status->horse(), new HorseTransformer());
    }
}
