<?php
namespace EQM\Models\Albums;

use EQM\Http\AbstractRouteBinding;
use EQM\Http\RouteBinding;

class AlbumRouteBinder extends AbstractRouteBinding implements RouteBinding
{
    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    /**
     * @param \EQM\Models\Albums\AlbumRepository $albums
     */
    public function __construct(AlbumRepository $albums)
    {
        $this->albums = $albums;
    }

    /**
     * @param int|string $slug
     * @return mixed
     */
    public function find($slug)
    {
        return $this->albums->findById($slug);
    }
}
