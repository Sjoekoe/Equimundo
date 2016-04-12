<?php
namespace EQM\Models\Companies\Users;

interface TeamMember
{
    const TYPE = 'team';
    const ID = 1;

    /**
     * @return mixed
     */
    public function isAdmin();
}
