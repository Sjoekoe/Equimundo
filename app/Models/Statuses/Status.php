<?php 
namespace HorseStories\Models\Statuses;
  
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{

    /**
     * @var string
     */
    protected $table = 'statuses';

    /**
     * @var array
     */
    protected $fillable = ['body'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo('HorseStories\Models\Horses\Horse');
    }

    public function user()
    {
        return $this->horse->owner;
    }
}