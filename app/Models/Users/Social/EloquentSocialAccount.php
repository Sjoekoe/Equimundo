<?php
namespace EQM\Models\Users\Social;

use Carbon\Carbon;
use EQM\Models\Users\EloquentUser;
use Illuminate\Database\Eloquent\Model;

class EloquentSocialAccount extends Model implements SocialAccount
{
    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'provider_user_id', 'provider'];

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userRelation()
    {
        return $this->belongsTo(EloquentUser::class, 'user_id', 'id');
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function user()
    {
        return $this->userRelation()->first();
    }

    /**
     * @return int
     */
    public function providerId()
    {
        return $this->provider_user_id;
    }

    /**
     * @return string
     */
    public function provider()
    {
        return $this->provider;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt()
    {
        return Carbon::parse($this->created_at);
    }

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt()
    {
        return Carbon::parse($this->updated_at);
    }
}
