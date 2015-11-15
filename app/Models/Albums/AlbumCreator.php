<?php
namespace EQM\Models\Albums;

use EQM\Core\Files\Uploader;
use EQM\Http\Requests\Request;
use EQM\Models\Horses\Horse;

class AlbumCreator
{
    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @param \EQM\Models\Albums\AlbumRepository $albums
     * @param \EQM\Core\Files\Uploader $uploader
     */
    public function __construct(AlbumRepository $albums, Uploader $uploader)
    {
        $this->albums = $albums;
        $this->uploader = $uploader;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Http\Requests\Request $request
     * @return \EQM\Models\Albums\Album
     */
    public function create(Horse $horse, Request $request)
    {
        $album = $this->albums->create($horse, $request->all());

        if (array_key_exists('pictures', $request->all())) {
            $this->handlePictures($horse, $request, $album);
        }

        return $album;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Http\Requests\Request $request
     * @param \EQM\Models\Albums\Album $album
     */
    private function handlePictures(Horse $horse, Request $request,Album $album)
    {
        $pictures = $request->file('pictures');

        foreach ($pictures as $picture) {
            $picture = $this->uploader->uploadPicture($picture, $horse);
            $picture->addToAlbum($album);
        }
    }
}
