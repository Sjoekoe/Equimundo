<?php
namespace EQM\Models\Roles;

class AdminRole extends EloquentRole implements Role
{
    /**
     * @return string
     */
    public function name()
    {
        return self::ADMIN;
    }
}
