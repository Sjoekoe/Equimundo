<?php
namespace EQM\Models\Palmares;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class PalmaresRouteBinder extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Palmares\PalmaresRepository
     */
    private $palmares;

    /**
     * @param \EQM\Models\Palmares\PalmaresRepository $palmares
     */
    public function __construct(PalmaresRepository $palmares)
    {
        $this->palmares = $palmares;
    }

    /**
     * @param int|string $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->palmares->findById($id);
    }
}
