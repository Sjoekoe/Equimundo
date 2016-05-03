<?php
namespace EQM\Models\Albums;

use EQM\Core\Database\CanMakeDatabaseTransactions;
use EQM\Core\Database\TransactionManager;
use EQM\Core\Files\Uploader;
use EQM\Http\Requests\Request;
use EQM\Models\Horses\Horse;
use EQM\Models\Statuses\Status;
use EQM\Models\Statuses\StatusRepository;

class AlbumCreator
{
    use CanMakeDatabaseTransactions;

    /**
     * @var \EQM\Models\Albums\AlbumRepository
     */
    private $albums;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @param \EQM\Core\Database\TransactionManager $transactionManager
     * @param \EQM\Models\Albums\AlbumRepository $albums
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     */
    public function __construct(
        TransactionManager $transactionManager,
        AlbumRepository $albums,
        Uploader $uploader,
        StatusRepository $statuses
    ) {
        $this->albums = $albums;
        $this->uploader = $uploader;
        $this->statuses = $statuses;
        $this->transactionManager = $transactionManager;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Http\Requests\Request $request
     * @return \EQM\Models\Albums\Album
     */
    public function create(Horse $horse, Request $request)
    {
        return $this->transaction(function() use ($horse, $request) {
            $album = $this->albums->create($horse, $request->all());

            $body = '<a href="/albums/' . $album->id() . '" class="text-mint">' . $album->name() . '</a>';

            $status = $this->statuses->create($horse, $body, Status::PREFIX_CREATED_ALBUM, route('album.show', $album->id()));

            if (array_key_exists('pictures', $request->all())) {
                $this->handlePictures($horse, $request, $album, $status);
            }

            return $album;
        });
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param \EQM\Http\Requests\Request $request
     * @param \EQM\Models\Albums\Album $album
     * @param \EQM\Models\Statuses\Status $status
     */
    private function handlePictures(Horse $horse, Request $request, Album $album, Status $status)
    {
        $pictures = $request->file('pictures');

        foreach ($pictures as $picture) {
            if ($picture) {
                $picture = $this->uploader->uploadPicture($picture, $horse);
                $picture->addToAlbum($album);
            }
        }

        if (count($album->pictures())) {
            $status->setPicture($album->pictures()->first());
        }
    }
}
