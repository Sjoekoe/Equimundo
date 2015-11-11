<?php
namespace EQM\Models\Statuses;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class StatusRouteBinder extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     */
    public function __construct(StatusRepository $statuses)
    {
        $this->statuses = $statuses;
    }

    /**
     * @param int|string $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->statuses->findById($id);
    }
}
