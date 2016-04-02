<?php
namespace EQM\Models\Advertising\Companies;

use EQM\Models\Addresses\EloquentAddress;
use EQM\Models\Advertising\Advertisements\EloquentAdvertisement;
use EQM\Models\Advertising\Contacts\EloquentAdvertisingContact;
use EQM\Models\UsesTimeStamps;
use Illuminate\Database\Eloquent\Model;

class EloquentAdvertisingCompany extends Model implements AdvertisingCompany
{
    use UsesTimeStamps;

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'tax', 'telephone', 'email', 'adv_contact_id', 'address_id'
    ];

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
    public function tax()
    {
        return $this->tax;
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
    public function email()
    {
        return $this->email;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function advertisementsRelation()
    {
        return $this->hasMany(EloquentAdvertisement::class, 'adv_company_id', 'id');
    }

    /**
     * @return \EQM\Models\Advertising\Advertisements\Advertisement[]
     */
    public function advertisements()
    {
        return $this->advertisementsRelation()->get();
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function contactRelation()
    {
        return $this->hasOne(EloquentAdvertisingContact::class, 'id', 'adv_contact_id');
    }

    /**
     * @return \EQM\Models\Advertising\Contacts\AdvertisingContact
     */
    public function contact()
    {
        return $this->contactRelation()->first();
    }
}
