<?php
namespace EQM\Models\Companies;

interface Stable
{
    const TYPE = 'stable';
    const ID = 1;
    
    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function horses();
}
