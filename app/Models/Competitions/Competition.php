<?php
namespace EQM\Models\Competitions;

interface Competition
{
    const TABLE = 'competitions';
    
    /**
     * @return mixed
     */
    public function id();

    /**
     * @return mixed
     */
    public function email();
}
