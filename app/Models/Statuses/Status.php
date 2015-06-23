<?php
namespace HorseStories\Models\Statuses;

use HorseStories\Models\Comments\Comment;
use HorseStories\Models\Horses\Horse;
use HorseStories\Models\Palmares\Palmares;
use HorseStories\Models\Pictures\Picture;
use HorseStories\Models\Users\User;
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
        return $this->belongsTo(Horse::class);
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
        return $this->hasMany(Comment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function palmares()
    {
        return $this->hasOne(Palmares::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pictures()
    {
        return $this->belongsToMany(Picture::class)->withTimestamps();
    }

    /**
     * @param \HorseStories\Models\Pictures\Picture $picture
     */
    public function setPicture($picture)
    {
        $this->pictures()->attach($picture);
    }

    public function hasPicture()
    {
        return count($this->pictures) !== 0;
    }

    public function getPicture()
    {
        return $this->pictures()->first();
    }
}
