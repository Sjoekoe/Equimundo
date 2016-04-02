<?php
namespace EQM\Models\Advertising\Advertisements;

use Carbon\Carbon;
use EQM\Models\Advertising\Companies\AdvertisingCompany;
use EQM\Models\Pictures\EloquentPicture;
use EQM\Models\UsesTimeStamps;
use Illuminate\Database\Eloquent\Model;

class EloquentAdvertisement extends Model implements Advertisement
{
    use UsesTimeStamps;
    
    protected $table = self::TABLE;
    
    protected $fillable = ['start', 'end', 'type', 'amount'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function start()
    {
        return $this->start ? Carbon::instance($this->start) : null;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function end()
    {
        return $this->end ? Carbon::instance($this->end) : null;
    }

    /**
     * @return int
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function paid()
    {
        return $this->paid;
    }

    /**
     * @return int
     */
    public function amount()
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function clicks()
    {
        return $this->clicks;
    }

    /**
     * @return int
     */
    public function views()
    {
        return $this->views;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyRelation()
    {
        return $this->belongsTo(AdvertisingCompany::class, 'adv_company_id', 'id');
    }

    /**
     * @return \EQM\Models\Advertising\Companies\AdvertisingCompany
     */
    public function company()
    {
        return $this->companyRelation()->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pictureRelation()
    {
        return $this->hasOne(EloquentPicture::class, 'id', 'picture_id');
    }

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function picture()
    {
        return $this->pictureRelation()->first();
    }
}
