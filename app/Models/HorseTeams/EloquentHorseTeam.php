<?php
namespace EQM\Models\HorseTeams;

use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Users\EloquentUser;
use Illuminate\Database\Eloquent\Model;

class EloquentHorseTeam extends Model implements HorseTeam
{
    /**
     * @var string
     */
    protected $table = 'horse_team';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'horse_id', 'type'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function user()
    {
        return $this->userRelation()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    private function userRelation()
    {
        return $this->belongsTo(EloquentUser::class, 'user_id', 'id');
    }

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse()
    {
        return $this->horseRelation()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    private function horseRelation()
    {
        return $this->belongsTo(EloquentHorse::class, 'horse_id', 'id');
    }

    /**
     * @return int
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt()
    {
        return $this->created_at;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt()
    {
        return $this->updated_at;
    }
}
