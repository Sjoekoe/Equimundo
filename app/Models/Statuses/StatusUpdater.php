<?php
namespace HorseStories\Models\Statuses;

class StatusUpdater
{
    /**
     * @param \HorseStories\Models\Statuses\Status $status
     * @param array $values
     */
    public function update(Status $status, $values)
    {
        $status->body = $values['status'];

        $status->save();
    }
}
