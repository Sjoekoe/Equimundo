<?php
namespace EQM\Models\Companies;

use EQM\Models\Addresses\EloquentAddress;
use EQM\Models\Companies\Users\CompanyUser;
use EQM\Models\Companies\Users\EloquentCompanyUser;
use EQM\Models\Companies\Users\Follower;
use EQM\Models\Companies\Users\TeamMember;
use EQM\Models\UsesTimeStamps;
use Illuminate\Database\Eloquent\Model;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

class EloquentCompany extends Model implements Company
{
    use UsesTimeStamps, SingleTableInheritanceTrait;

    /**
     * @var string
     */
    protected static $singleTableTypeField = 'type';

    /**
     * @var array
     */
    protected static $singleTableSubclasses = [EloquentStable::class];

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['name', 'website', 'about'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function slug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function website()
    {
        return $this->website;
    }

    /**
     * @return string
     */
    public function telephone()
    {
        return $this->telephone;
    }

    /**
     * @return string
     */
    public function about()
    {
        return $this->about;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function addressRelation()
    {
        return $this->hasOne(EloquentAddress::class, 'id', 'address_id');
    }

    /**
     * @return \EQM\Models\Addresses\Address
     */
    public function address()
    {
        return $this->addressRelation()->first();
    }

    public function userTeamRelation()
    {
        return $this->hasMany(EloquentCompanyUser::class, 'company_id', 'id');
    }

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function userTeams()
    {
        $this->userTeamRelation()->filter(function (CompanyUser $user) {
            return $user instanceof TeamMember;
        });
    }

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function followers()
    {
        $this->userTeamRelation()->filter(function (CompanyUser $user) {
            return $user instanceof Follower;
        });
    }

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }
}
