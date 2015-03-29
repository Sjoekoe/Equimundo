<?php 
namespace HorseStories\Models\Comments;
  
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'status_id', 'body'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poster()
    {
        return $this->belongsTo('\HorseStories\Models\Users\User', 'user_id');
    }
}