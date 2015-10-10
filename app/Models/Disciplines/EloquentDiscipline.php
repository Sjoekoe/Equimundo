<?php
namespace EQM\Models\Disciplines;

use EQM\Models\Horses\EloquentHorse;
use Illuminate\Database\Eloquent\Model;

class EloquentDiscipline extends Model implements Discipline
{
    /**
     * @var string
     */
    protected $table = 'disciplines';

    /**
     * @var array
     */
    protected $fillable = ['discipline'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function discipline()
    {
        return $this->discipline;
    }

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse()
    {
        return $this->belongsTo(EloquentHorse::class, 'horse_id');
    }

    /**
     * @return \DateTime
     */
    public function createdAt()
    {
        return $this->created_at;
    }

    /**
     * @return \DateTime
     */
    public function updatedAt()
    {
        return $this->updated_at;
    }
}
