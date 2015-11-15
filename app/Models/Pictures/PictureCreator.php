<?php
namespace EQM\Models\Pictures;

use EQM\Core\Files\Uploader;
use EQM\Http\Requests\Request;
use EQM\Models\Albums\Album;

class PictureCreator
{
    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @param \EQM\Core\Files\Uploader $uploader
     */
    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     * @param \EQM\Http\Requests\Request $request
     */
    public function create(Album $album, Request $request)
    {
        $pictures = $request->file('pictures');

        foreach ($pictures as $picture) {
            $picture = $this->uploader->uploadPicture($picture, $album->horse());

            $picture->addToAlbum($album);
        }
    }
}
