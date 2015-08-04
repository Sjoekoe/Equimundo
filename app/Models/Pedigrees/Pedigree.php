<?php
namespace EQM\Models\Pedigrees;

use EQM\Models\Horses\Horse;
use Illuminate\Database\Eloquent\Model;

class Pedigree extends Model
{
    const FATHER = 1;
    const MOTHER = 2;
    const SON = 3;
    const DAUGHTER = 4;

    /**
     * @var array
     */
    protected $fillable = ['horse_id', 'type', 'family_id'];

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
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function father()
    {
        return $this->originalHorse()->first()->father();
    }
}
