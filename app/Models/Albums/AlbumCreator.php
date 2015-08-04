<?php
namespace EQM\Models\Albums;

use EQM\Models\Horses\Horse;

class AlbumCreator
{
    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     * @return \EQM\Models\Albums\Album
     */
    public function create(Horse $horse, $values)
    {
        $album = new Album();
        $album->horse_id = $horse->id;
        $album->name = $values['name'];
        $album->description = $values['description'];

        $album->save();

        return $album;
    }
}
