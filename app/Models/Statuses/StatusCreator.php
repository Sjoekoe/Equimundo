<?php
namespace EQM\Models\Statuses;

use EQM\Core\Files\Uploader;
use EQM\Models\Albums\Album;
use EQM\Models\Horses\HorseRepository;

class StatusCreator
{
    /**
     * @var \EQM\Models\Statuses\StatusRepository
     */
    private $statuses;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @param \EQM\Models\Statuses\StatusRepository $statuses
     * @param \EQM\Models\Horses\HorseRepository $horses
     * @param \EQM\Core\Files\Uploader $uploader
     */
    public function __construct(StatusRepository $statuses, HorseRepository $horses, Uploader $uploader)
    {
        $this->statuses = $statuses;
        $this->horses = $horses;
        $this->uploader = $uploader;
    }

    /**
     * @param array $values
     * @return \EQM\Models\Statuses\Status
     */
    public function create($values)
    {
        $horse = $this->horses->findById($values['horse']);
        $status = $this->statuses->create($horse, $values['body']);
        $horse = $this->horses->findById($values['horse']);

        if (array_key_exists('picture', $values)) {
            $picture = $this->uploader->uploadPicture($values['picture'], $horse);

            $picture->addToAlbum($horse->getStandardAlbum(Album::TIMELINEPICTURES));
            $status->setPicture($picture);

            $status->save();
        }

        if (array_key_exists('movie', $values)) {
            $movie = $this->uploader->uploadMovie($values['movie'], $horse);

            $status->setPicture($movie);

            $status->save();
        }

        return $status;
    }
}
