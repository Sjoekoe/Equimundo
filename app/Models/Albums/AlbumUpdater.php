<?php
namespace EQM\Models\Albums;

class AlbumUpdater
{
    /**
     * @param \EQM\Models\Albums\Album $album
     * @param array $values
     * @return \EQM\Models\Albums\Album
     */
    public function update(Album $album, $values)
    {
        $album->name = $values['name'];
        $album->description = $values['description'];
        $album->save();

        return $album;
    }
}
