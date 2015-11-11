<?php
namespace EQM\Models\Pedigrees;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class PedigreeRouteBinder extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Pedigrees\PedigreeRepository
     */
    private $pedigrees;

    /**
     * @param \EQM\Models\Pedigrees\PedigreeRepository $pedigrees
     */
    public function __construct(PedigreeRepository $pedigrees)
    {
        $this->pedigrees = $pedigrees;
    }

    /**
     * @param int|string $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->pedigrees->findById($id);
    }
}
