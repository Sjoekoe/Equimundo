<?php
namespace EQM\Models\Invites;

use EQM\Models\Users\EloquentUser;
use Illuminate\Database\Eloquent\Model;

class EloquentFriendInvites extends Model implements FriendInvites
{
    protected $table = self::TABLE;

    protected $fillable = ['email'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected function userRelation()
    {
        return $this->belongsTo(EloquentUser::class, 'user_id', 'id');
    }

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
    public function email()
    {
        return $this->email;
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function user()
    {
        return $this->userRelation()->get();
    }
}
