<?php
namespace EQM\Models\Companies;

use EQM\Models\Addresses\EloquentAddress;
use EQM\Models\UsesTimeStamps;
use Illuminate\Database\Eloquent\Model;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

abstract class EloquentCompany extends Model
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
    public function website()
    {
        return $this->website;
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

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function userTeams()
    {
        // TODO: Implement users() method.
    }

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function followers()
    {
        // TODO: Implement followers() method.
    }
}
