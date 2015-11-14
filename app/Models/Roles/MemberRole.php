<?php
namespace EQM\Models\Roles;

class MemberRole extends EloquentRole implements Role
{
    /**
     * @return string
     */
    public function name()
    {
        return self::MEMBER;
    }
}
