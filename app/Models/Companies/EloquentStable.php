<?php
namespace EQM\Models\Companies;

class EloquentStable extends EloquentCompany implements Stable, Company
{
    /**
     * @var string
     */
    protected static $singleTableType = self::TYPE;
    
    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function horses()
    {
        // TODO: Implement horses() method.
    }

    /**
     * @return string
     */
    public function type()
    {
        return self::TYPE;
    }
}
