<?php
namespace EQM\Models;

use Carbon\Carbon;

trait UsesTimeStamps
{
    /**
     * @return \Carbon\Carbon
     */
    public function createdAt()
    {
        return Carbon::instance($this->created_at);
    }

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt()
    {
        return Carbon::instance($this->upated_at);
    }
}
