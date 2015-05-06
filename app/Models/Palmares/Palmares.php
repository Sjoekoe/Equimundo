<?php
namespace HorseStories\Models\Palmares;

use Illuminate\Database\Eloquent\Model;

class Palmares extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['horse_id', 'event_id', 'discipline', 'ranking', 'level'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo('HorseStories\Models\Horses\Horse');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo('HorseStories\Models\Events\Event');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function status()
    {
        return $this->hasOne('HorseStories\Models\Statuses\Status');
    }
}