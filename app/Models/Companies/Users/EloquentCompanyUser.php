<?php
namespace EQM\Models\Companies\Users;

use EQM\Models\UsesTimeStamps;
use Illuminate\Database\Eloquent\Model;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

abstract class EloquentCompanyUser extends Model
{
    use UsesTimeStamps, SingleTableInheritanceTrait;

    /**
     * @var string
     */
    protected static $singleTableTypeField = 'type';

    /**
     * @var array
     */
    protected static $singleTableSubclasses = [EloquentFollower::class, EloquentTeamMember::class];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function user()
    {
        // TODO: Implement user() method.
    }

    /**
     * @return \EQM\Models\Companies\Company
     */
    public function company()
    {
        // TODO: Implement company() method.
    }
}
