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

    /**
     * @return \HorseStories\Models\Users\User
     */
    public function user()
    {
        return $this->horse()->owner();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('HorseStories\Models\Comments\Comment');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany('HorseStories\Models\Users\User', 'likes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function palmares()
    {
        return $this->hasOne('HorseStories\Models\Palmares\Palmares');
    }
}