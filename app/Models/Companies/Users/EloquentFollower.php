<?php
namespace EQM\Models\Companies\Users;

class EloquentFollower extends EloquentCompanyUser implements CompanyUser, Follower
{
    /**
     * @var string
     */
    protected static $singleTableType = self::TYPE;
    
    /**
     * @return string
     */
    public function type()
    {
        return self::TYPE;
    }
}
