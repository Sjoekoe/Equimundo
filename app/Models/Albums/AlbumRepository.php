<?php
namespace EQM\Models\Albums;

use EQM\Models\Horses\Horse;

class AlbumRepository
{
    /**
     * @var \EQM\Models\Albums\Album
     */
    private $album;

    /**
     * @param \EQM\Models\Albums\Album $album
     */
    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Albums\Album
     */
    public function findById($id)
    {
        return $this->album->where('id', $id)->firstOrFail();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Albums\Album[]
     */
    public function findForHorse(Horse $horse)
    {
        return $this->album->where('horse_id', $horse->id)->where('type', 0)->get();
    }
}
