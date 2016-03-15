<?php
namespace EQM\Models\Comments;

use Carbon\Carbon;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Users\EloquentUser;
use EQM\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class EloquentComment extends Model implements Comment
{
    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'status_id', 'body'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function poster()
    {
        return $this->belongsTo(EloquentUser::class, 'user_id', 'id')->first();
    }

    /**
     * @return \EQM\Models\Statuses\Status
     */
    public function status()
    {
        return $this->belongsTo(EloquentStatus::class, 'status_id', 'id')->first();
    }

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function likes()
    {
        return $this->belongsToMany(EloquentUser::class, 'comment_likes', 'comment_id', 'user_id')->get();
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return bool
     */
    public function isLikedByUser(User $user)
    {
        foreach ($this->likes() as $liker) {
            if ($liker->id() == $user->id()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt()
    {
        return Carbon::instance($this->created_at);
    }
}
