<?php
namespace EQM\Models\Advertising\Advertisements;

use Carbon\Carbon;
use EQM\Models\Advertising\Companies\EloquentAdvertisingCompany;
use EQM\Models\Pictures\EloquentPicture;
use EQM\Models\UsesTimeStamps;
use Illuminate\Database\Eloquent\Model;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

class EloquentAdvertisement extends Model implements Advertisement
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
    protected static $singleTableSubclasses = [EloquentRectangle::class, EloquentLeaderBoard::class];

    /**
     * @var array
     */
    protected $fillable = [
        'start', 'end', 'type', 'amount', 'adv_company_id', 'picture_id', 'clicks', 'views', 'paid',
        'website'
    ];

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
        return $this->start ? Carbon::parse($this->start) : null;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function end()
    {
        return $this->end ? Carbon::parse($this->end) : null;
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
     * @return string
     */
    public function website()
    {
        return $this->website;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function companyRelation()
    {
        return $this->belongsTo(EloquentAdvertisingCompany::class, 'adv_company_id', 'id');
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

    /**
     * @return string
     */
    public function type()
    {
        return $this->type;
    }
}
