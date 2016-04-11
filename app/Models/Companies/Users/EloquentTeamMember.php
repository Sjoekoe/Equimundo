<?php
namespace EQM\Models\Companies\Users;

class EloquentTeamMember extends EloquentCompanyUser implements CompanyUser, TeamMember
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

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }
}
