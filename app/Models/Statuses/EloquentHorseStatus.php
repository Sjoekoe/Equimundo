<?php
namespace EQM\Models\Statuses;

use EQM\Models\Horses\EloquentHorse;

class EloquentHorseStatus extends EloquentStatus implements Status, HorseStatus
{
    /**
     * @var string
     */
    protected static $singleTableType = self::TYPE;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horseRelation()
    {
        return $this->belongsTo(EloquentHorse::class, 'horse_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->horseRelation()->first();
    }

    /**
     * @return string
     */
    public function type()
    {
        return self::TYPE;
    }

    public function poster()
    {
        return $this->belongsTo(EloquentHorse::class, 'horse_id', 'id');
    }
}
