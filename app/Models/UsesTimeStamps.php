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
        return Carbon::parse($this->created_at);
    }

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt()
    {
        return Carbon::parse($this->upated_at);
    }
}
