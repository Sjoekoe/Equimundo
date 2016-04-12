<?php
namespace EQM\Models\Companies\Users;

use EQM\Models\Companies\EloquentCompany;
use EQM\Models\Users\EloquentUser;
use EQM\Models\UsesTimeStamps;
use Illuminate\Database\Eloquent\Model;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

class EloquentCompanyUser extends Model implements CompanyUser
{
    use UsesTimeStamps, SingleTableInheritanceTrait;

    /**
     * @var string
     */
    protected $table = self::TABLE;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRelation()
    {
        return $this->belongsTo(EloquentUser::class, 'user_id', 'id');
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function user()
    {
        return $this->userRelation()->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyRelation()
    {
        return $this->belongsTo(EloquentCompany::class, 'company_id', 'id');
    }

    /**
     * @return \EQM\Models\Companies\Company
     */
    public function company()
    {
        return $this->companyRelation()->first();
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }
}
