<?php
namespace EQM\Models\Statuses;

use EQM\Models\Comments\EloquentComment;
use EQM\Models\Horses\Horse;
use EQM\Models\Palmares\Palmares;
use EQM\Models\Pictures\Picture;
use EQM\Models\Users\User;
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
    protected $fillable = ['body', 'prefix'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo(Horse::class);
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function user()
    {
        return $this->horse->owner;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(EloquentComment::class);
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
     * @param \EQM\Models\Pictures\Picture $picture
     */
    public function setPicture($picture)
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
}
