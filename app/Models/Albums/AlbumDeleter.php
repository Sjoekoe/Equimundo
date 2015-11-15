<?php
namespace EQM\Models\Albums;

use EQM\Models\Pictures\Picture;
use Illuminate\Filesystem\Filesystem;

class AlbumDeleter
{
    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @param \EQM\Models\Albums\AlbumRepository $albums
     * @param \Illuminate\Filesystem\Filesystem $filesystem
     */
    public function __construct(AlbumRepository $albums, Filesystem $filesystem)
    {
        $this->albums = $albums;
        $this->filesystem = $filesystem;
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     */
    public function delete(Album $album)
    {
        foreach ($album->pictures() as $picture) {
            $this->handlePictures($album, $picture);
        }

        $this->albums->delete($album);
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     * @param \EQM\Models\Pictures\Picture $picture
     */
    private function handlePictures(Album $album, Picture $picture)
    {
        if (count($picture->albums()) > 1) {
            $picture->removeFromAlbum($album);
        } else {
            $this->filesystem->delete('/uploads/pictures/' . $picture->horse()->id() . '/' . $picture->path());

            $picture->delete();
        }
    }
}
