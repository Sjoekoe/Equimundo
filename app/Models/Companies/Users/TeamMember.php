<?php
namespace EQM\Models\Companies\Users;

interface TeamMember
{
    const TYPE = 'team';

    /**
     * @return mixed
     */
    public function isAdmin();
}
