<?php 
namespace HorseStories\Models\Statuses;
  
class StatusCreator 
{
    /**
     * @param array $data
     */
    public function create($data = [])
    {
        $status = new Status();
        $status->body = $data['status'];
        $status->horse_id = $data['horse'];

        $status->save();
    }
}