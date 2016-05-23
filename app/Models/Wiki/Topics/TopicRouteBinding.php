<?php
namespace EQM\Models\Wiki\Topics;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class TopicRouteBinding extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Wiki\Topics\TopicRepository
     */
    private $topics;

    public function __construct(TopicRepository $topics)
    {
        $this->topics = $topics;
    }

    /**
     * @param int|string $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->topics->find($id);
    }
}
