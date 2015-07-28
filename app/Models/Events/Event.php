<?php
namespace EQM\Models\Events;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['creator_id', 'name', 'place', 'description', 'date'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('EQM\Models\Users\User', 'id', 'creator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function palmares()
    {
        return $this->hasMany('EQM\Models\Palmares\Palmares');
    }
}