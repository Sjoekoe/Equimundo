<?php
namespace EQM\Models\Palmares;

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
        return $this->belongsTo('EQM\Models\Horses\Horse');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo('EQM\Models\Events\Event');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('EQM\Models\Statuses\Status');
    }
}