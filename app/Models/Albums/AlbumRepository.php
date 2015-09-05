<?php
namespace EQM\Models\Albums;

use EQM\Models\Horses\Horse;

interface AlbumRepository
{
    /**
     * @param int $id
     * @return \EQM\Models\Albums\Album
     */
    public function findById($id);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return \EQM\Models\Albums\Album[]
     */
    public function findForHorse(Horse $horse);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     * @return \EQM\Models\Albums\Album
     */
    public function create(Horse $horse, $values);

    /**
     * @param \EQM\Models\Albums\Album $album
     * @param array $values
     * @return \EQM\Models\Albums\Album
     */
    public function update(Album $album, $values);

    /**
     * @param \EQM\Models\Albums\Album $album
     */
    public function delete(Album $album);

    /**
     * @param \EQM\Models\Horses\Horse $horse
     */
    public function createStandardAlbums(Horse $horse);
}
