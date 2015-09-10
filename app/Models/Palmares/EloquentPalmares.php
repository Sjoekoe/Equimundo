<?php
namespace EQM\Models\Palmares;

use EQM\Models\Events\EloquentEvent;
use EQM\Models\Horses\Horse;
use EQM\Models\Statuses\EloquentStatus;
use Illuminate\Database\Eloquent\Model;

class EloquentPalmares extends Model implements Palmares
{
    /**
     * @var string
     */
    protected $table = 'palmares';

    /**
     * @var array
     */
    protected $fillable = ['horse_id', 'event_id', 'status_id', 'discipline', 'ranking', 'level', 'date'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo(Horse::class)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(EloquentEvent::class, 'event_id')->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(EloquentStatus::class)->first();
    }

    /**
     * @return int
     */
    public function discipline()
    {
        return $this->discipline;
    }

    /**
     * @return string
     */
    public function ranking()
    {
        return $this->ranking;
    }

    /**
     * @return string
     */
    public function level()
    {
        return $this->level;
    }

    /**
     * @return \dateTime
     */
    public function date()
    {
        return $this->date;
    }
}
