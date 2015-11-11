<?php
namespace EQM\Models\Pictures;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class PictureRouteBinder extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Pictures\PictureRepository
     */
    private $pictures;

    /**
     * @param \EQM\Models\Pictures\PictureRepository $pictures
     */
    public function __construct(PictureRepository $pictures)
    {
        $this->pictures = $pictures;
    }

    /**
     * @param int|string $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->pictures->findById($id);
    }
}
