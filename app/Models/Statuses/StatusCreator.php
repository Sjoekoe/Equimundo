<?php 
namespace HorseStories\Models\Statuses;
  
use HorseStories\Models\Horses\Horse;

class StatusCreator
{
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