<?php
namespace EQM\Models\Comments;

use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Users\EloquentUser;
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
}
