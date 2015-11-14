<?php
namespace EQM\Models\Roles;

use EQM\Models\Users\User;

interface RoleRepository
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Roles\Role $role
     * @return \EQM\Models\Roles\Role
     */
    public function create(User $user, Role $role);
}
