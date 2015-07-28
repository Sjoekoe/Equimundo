<?php
namespace EQM\Models\Statuses;

class StatusUpdater
{
    /**
     * @param \EQM\Models\Statuses\Status $status
     * @param array $values
     */
    public function update(Status $status, $values)
    {
        $status->body = $values['status'];

        $status->save();
    }
}
