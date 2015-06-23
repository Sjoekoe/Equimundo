<?php
namespace HorseStories\Models\Statuses;

use HorseStories\Core\Files\Uploader;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Horses\HorseRepository;

class StatusCreator
{
    /**
     * @var \HorseStories\Core\Files\Uploader
     */
    private $uploader;

    /**
     * @var \HorseStories\Models\Horses\HorseRepository
     */
    private $horses;

    /**
     * @param \HorseStories\Core\Files\Uploader $uploader
     * @param \HorseStories\Models\Horses\HorseRepository $horses
     */
    public function __construct(Uploader $uploader, HorseRepository $horses)
    {
        $this->uploader = $uploader;
        $this->horses = $horses;
    }

    /**
     * @param array $data
     * @return \HorseStories\Models\Statuses\Status
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

            $status->setPicture($picture);
        }

        return $status;
    }

    /**
     * @param \HorseStories\Models\Horses\Horse $horse
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
