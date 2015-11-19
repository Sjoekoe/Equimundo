<?php
namespace EQM\Models\Pedigrees;

use EQM\Models\Horses\EloquentHorse;
use Illuminate\Database\Eloquent\Model;

class EloquentPedigree extends Model implements Pedigree
{
    /**
     * @var string
     */
    protected $table = 'pedigrees';

    /**
     * @var array
     */
    protected $fillable = ['horse_id', 'type', 'family_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo(EloquentHorse::class, 'horse_id', 'id')->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function originalHorse()
    {
        return $this->hasOne(EloquentHorse::class, 'id', 'family_id');
    }

    /**
     * @return bool
     */
    public function hasFather()
    {
        if ($this->originalHorse()->first()) {
            return true;
        }

        return false;
    }

    /**
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function father()
    {
        return $this->originalHorse()->first()->father();
    }

    /**
     * @return int
     */
    public function type()
    {
        return $this->type;
    }
}
