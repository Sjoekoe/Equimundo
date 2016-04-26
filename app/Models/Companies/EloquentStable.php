<?php
namespace EQM\Models\Companies;

use AlgoliaSearch\Laravel\AlgoliaEloquentTrait;

class EloquentStable extends EloquentCompany implements Stable, Company
{
    use AlgoliaEloquentTrait;

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
