<?php
namespace EQM\Models\Roles;

use EQM\Models\Users\User;

class EloquentRoleRepository implements RoleRepository
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Roles\Role $role
     * @return \EQM\Models\Roles\Role
     */
    public function create(User $user, Role $role)
    {
        $userRole = new EloquentRole();
        $userRole->user_id = $user->id();
        $userRole->role = $role->name();

        $userRole->save();

        return $userRole;
    }
}
