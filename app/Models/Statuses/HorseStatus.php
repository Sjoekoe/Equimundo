<?php
namespace EQM\Models\Statuses;

interface HorseStatus
{
    const TYPE = 'horse';
    
    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse();
}
