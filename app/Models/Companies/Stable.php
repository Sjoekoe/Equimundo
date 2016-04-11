<?php
namespace EQM\Models\Companies;

interface Stable
{
    const TYPE = 'stable';
    
    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function horses();
}
