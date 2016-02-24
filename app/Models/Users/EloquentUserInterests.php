<?php
namespace EQM\Models\Users;

use Illuminate\Database\Eloquent\Model;

class EloquentUserInterests extends Model implements UserInterests
{
    protected $table = self::TABLE;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    private function userRelation()
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
     * @return \EQM\Models\users\User
     */
    public function user()
    {
        return $this->userRelation()->get();
    }

    /**
     * @return int
     */
    public function type()
    {
        return $this->type;
    }
}
