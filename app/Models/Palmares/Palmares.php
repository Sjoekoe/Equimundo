<?php
namespace EQM\Models\Palmares;

use EQM\Models\Events\EloquentEvent;
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
        return $this->belongsTo(EloquentEvent::class, 'event_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo('EQM\Models\Statuses\Status');
    }
}
