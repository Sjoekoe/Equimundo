<?php
namespace EQM\Models\Pictures;

use EQM\Models\Albums\Album;
use Illuminate\Contracts\Filesystem\Filesystem;

class PictureDeleter
{
    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem
     */
    private $filesystem;

    /**
     * @param \Illuminate\Contracts\Filesystem\Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     * @param \EQM\Models\Pictures\Picture $picture
     */
    public function delete(Album $album, Picture $picture)
    {
        if (count($picture->albums()) > 1) {
            $picture->removeFromAlbum($album);
        } else {
            $this->filesystem->delete('/uploads/pictures/' . $picture->horse()->id() . '/' . $picture->path());

            $picture->delete();
        }
    }
}
