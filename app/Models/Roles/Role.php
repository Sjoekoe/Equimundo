<?php
namespace EQM\Models\Roles;

interface Role
{
    const MEMBER = 'member';
    const ADMIN = 'admin';

    /**
     * @return string
     */
    public function name();
}
