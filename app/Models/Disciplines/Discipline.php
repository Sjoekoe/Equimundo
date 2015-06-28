<?php
namespace HorseStories\Models\Disciplines;

use HorseStories\Models\Horses\Horse;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $fillable = ['discipline'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo(Horse::class);
    }
}
