<?php
namespace EQM\Models\Albums;

use EQM\Models\Horses\Horse;

class EloquentAlbumRepository implements AlbumRepository
{
    /**
     * @var \EQM\Models\Albums\Album
     */
    private $album;

    /**
     * @param \EQM\Models\Albums\Album $album
     */
    public function __construct(EloquentAlbum $album)
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
        return $this->album->where('horse_id', $horse->id())->whereNull('type')->get();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $values
     * @return \EQM\Models\Albums\Album
     */
    public function create(Horse $horse, $values)
    {
        $album = new EloquentAlbum();
        $album->horse_id = $horse->id();
        $album->name = $values['name'];

        if (array_key_exists('description', $values)) {
            $album->description = $values['description'];
        }

        if (array_key_exists('type', $values)) {
            $album->type = $values['type'];
        }

        $album->save();

        return $album;
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     * @param array $values
     * @return \EQM\Models\Albums\Album
     */
    public function update(Album $album, $values)
    {
        if (array_key_exists('name', $values)) {
            $album->name = $values['name'];
        }

        $album->description = $values['description'];
        $album->save();

        return $album;
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     */
    public function delete(Album $album)
    {
        $album->delete();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     */
    public function createStandardAlbums(Horse $horse)
    {
        $this->create($horse, [
            'name' => 'profile_pictures',
            'type' => Album::PROFILEPICTURES,
        ]);

        $this->create($horse, [
            'name' => 'cover_album',
            'type' => Album::COVERPICTURES,
        ]);

        $this->create($horse, [
            'name' => 'timeline_album',
            'type' => Album::TIMELINEPICTURES,
        ]);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param int $type
     * @param string $title
     * @return \EQM\Models\Albums\Album
     */
    public function createStandardAlbum(Horse $horse, $type, $title)
    {
        return $this->create($horse, [
            'name' => $title,
            'type' => $type,
        ]);
    }
}
