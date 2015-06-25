<?php
namespace HorseStories\Models\Pedigrees;

use HorseStories\Models\Horses\Horse;
use Illuminate\Database\Eloquent\Model;

class Pedigree extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['horse_id', 'type', 'family_name', 'family_life_number', 'family_id', 'date_of_birth', 'date_of_death', 'color', 'height', 'breed'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo(Horse::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function originalHorse()
    {
        return $this->hasOne(Horse::class, 'id', 'family_id');
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
     * @return \HorseStories\Models\Pedigrees\Pedigree
     */
    public function father()
    {
        return $this->originalHorse()->first()->father();
    }
}
