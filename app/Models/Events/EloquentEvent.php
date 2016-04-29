<?php
namespace EQM\Models\Events;

use Carbon\Carbon;
use EQM\Models\Addresses\EloquentAddress;
use EQM\Models\Palmares\EloquentPalmares;
use EQM\Models\Users\EloquentUser;
use Illuminate\Database\Eloquent\Model;

class EloquentEvent extends Model implements Event
{
    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['creator_id', 'name', 'place', 'description', 'date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creatorRelation()
    {
        return $this->belongsTo(EloquentUser::class, 'creator_id', 'id');
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function creator()
    {
        return $this->creatorRelation()->first();
    }

    /**
     * @return \EQM\Models\Palmares\Palmares
     */
    public function palmares()
    {
        return $this->hasMany(EloquentPalmares::class, 'palmares_id', 'id')->get();
    }

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
     * @return int
     */
    public function place()
    {
        return $this->place;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function startDate()
    {
        return $this->start_date ? Carbon::parse($this->start_date) : null;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function endDate()
    {
        return $this->end_date ? Carbon::parse($this->end_date) : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function addressRelation()
    {
        return $this->belongsTo(EloquentAddress::class, 'address_id', 'id');
    }

    /**
     * @return \EQM\Models\Addresses\Address
     */
    public function address()
    {
        return $this->addressRelation()->first();
    }
}
