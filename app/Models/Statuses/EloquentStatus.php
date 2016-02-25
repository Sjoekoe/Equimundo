<?php
namespace EQM\Models\Statuses;

use Carbon\Carbon;
use EQM\Models\Comments\EloquentComment;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Palmares\EloquentPalmares;
use EQM\Models\Pictures\EloquentPicture;
use EQM\Models\Pictures\Picture;
use EQM\Models\Users\EloquentUser;
use EQM\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class EloquentStatus extends Model implements Status
{
    /**
     * @var string
     */
    protected $table = 'statuses';

    /**
     * @var array
     */
    protected $fillable = ['body', 'prefix', 'horse_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo(EloquentHorse::class)->first();
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function user()
    {
        return $this->horse()->owner;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(EloquentComment::class, 'status_id', 'id')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(EloquentUser::class, 'likes', 'status_id', 'user_id')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function palmares()
    {
        return $this->hasOne(EloquentPalmares::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pictures()
    {
        return $this->belongsToMany(EloquentPicture::class, 'picture_status', 'status_id', 'picture_id')->withTimestamps();
    }

    /**
     * @param \EQM\Models\Pictures\Picture $picture
     */
    public function setPicture(Picture $picture)
    {
        $this->pictures()->attach($picture);
    }

    /**
     * @return bool
     */
    public function hasPicture()
    {
        return count($this->pictures) !== 0;
    }

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function getPicture()
    {
        return $this->pictures()->first();
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
    public function body()
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function prefix()
    {
        return $this->prefix;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function createdAt()
    {
        return Carbon::instance($this->created_at);
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return bool
     */
    public function isLikedByUser(User $user)
    {
        foreach ($this->likes() as $like) {
            if ($like->id() === $user->id()) {
                return true;
            }
        }

        return false;
    }
}
