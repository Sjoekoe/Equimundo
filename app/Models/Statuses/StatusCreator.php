<?php
namespace EQM\Models\Statuses;

use EQM\Core\Files\Uploader;
use EQM\Models\Albums\Album;
use EQM\Models\Horses\Horse;
use EQM\Models\Horses\HorseRepository;

class StatusCreator
{
    /**
     * @var \EQM\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \EQM\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \EQM\Core\Files\Uploader $uploader
     * @param \EQM\Models\Horses\HorseRepository $horses
     */
    public function __construct(Uploader $uploader, HorseRepository $horses)
    {
        $this->uploader = $uploader;
        $this->horses = $horses;
    }

    /**
     * @param array $data
     * @return \EQM\Models\Statuses\Status
     */
    public function create($data = [])
    {
        $status = new Status();
        $status->body = $data['status'];
        $status->horse_id = $data['horse'];

        $status->save();

        if (array_key_exists('picture', $data)) {
            $horse = $this->horses->findById($data['horse']);
            $picture = $this->uploader->uploadPicture($data['picture'], $horse);

            $picture->addToAlbum($horse->getStandardAlbum(Album::TIMELINEPICTURES));
            $status->setPicture($picture);
        }

        return $status;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @param array $data
     * @return array
     */
    public function createForPalmares(Horse $horse, $data = [])
    {
        $data['status'] = $horse->name  . ' has added an achievement.<br>';
        $data['status'] .= 'She finished ' . $data['ranking'] . ' at ' . $data['event_name']  . ' in the ' . $data['level'] . ' category<br><hr>';
        $data['status'] .= nl2br($data['body']);

        $data['horse'] = $horse->id;

        $data['status'] = $this->create($data);

        return $data;
    }
}
