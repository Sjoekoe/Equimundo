<?php
namespace EQM\Models\Roles;

use Illuminate\Database\Eloquent\Model;

class EloquentRole extends Model implements Role
{
    /**
     * @var string
     */
    protected $table = 'role_user';

    /**
     * @return string
     */
    public function name()
    {
        $this->role;
    }
}
