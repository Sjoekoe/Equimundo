<?php
namespace EQM\Api\Statuses;

use EQM\Api\Companies\CompanyTransformer;
use EQM\Models\Statuses\Status;

class CompanyStatusTransformer extends StatusTransformer
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'comments',
        'likes',
        'companyRelation',
    ];

    /**
     * @param \EQM\Models\Statuses\Status $status
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeCompanyRelation(Status $status)
    {
        return $this->item($status->company(), new CompanyTransformer());
    }
}
