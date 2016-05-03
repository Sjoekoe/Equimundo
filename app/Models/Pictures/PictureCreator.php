<?php
namespace EQM\Models\Pictures;

use EQM\Core\Database\CanMakeDatabaseTransactions;
use EQM\Core\Database\TransactionManager;
use EQM\Core\Files\Uploader;
use EQM\Http\Requests\Request;
use EQM\Models\Albums\Album;
use EQM\Models\Statuses\Status;
use EQM\Models\Statuses\StatusRepository;
use Illuminate\Support\Collection;

class PictureCreator
{
    use CanMakeDatabaseTransactions;

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
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     */
    public function __construct(
        TransactionManager $transactionManager,
        Uploader $uploader,
        StatusRepository $statuses
    ) {
        $this->uploader = $uploader;
        $this->transactionManager = $transactionManager;
        $this->statuses = $statuses;
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     * @param \EQM\Http\Requests\Request $request
     */
    public function create(Album $album, Request $request)
    {
        $this->transaction(function() use ($album, $request) {
            $pictures = $request->file('pictures');

            foreach ($pictures as $picture) {
                $picture = $this->uploader->uploadPicture($picture, $album->horse());

                $picture->addToAlbum($album);
            }

            $body = '<a href="/albums/' . $album->id() . '" class="text-mint">' . $album->name() . '</a>';
            $status = $this->statuses->create($album->horse(), $body, Status::PREFIX_ADDED_PICTURES, route('album.show', $album->id()));

            $status->setPicture($album->pictures()->first());
        });

    }
}
