<?php 
namespace HorseStories\Models\Horses;
  
use Illuminate\Database\Eloquent\Model;

class Horse extends Model
{
    /**
     * The table name used by the entity
     *
     * @var string
     */
    protected $table = 'horses';

    /**
     * The fillable fields in the database
     *
     * @var array
     */
    protected $fillable = [
        'name', 'gender', 'breed', 'height', 'date_of_birth', 'color', 'life_number', 'user_id'
    ];

    public function owner()
    {
        return $this->belongsTo('HorseStories\Models\Users\User');
    }
}