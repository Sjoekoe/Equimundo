<?php
namespace EQM\Models\Pictures;

use EQM\Models\Albums\Album;
use EQM\Models\Albums\EloquentAlbum;
use EQM\Models\Horses\Horse;
use Illuminate\Database\Eloquent\Model;

class EloquentPicture extends Model implements Picture
{
    /**
     * @var string
     */
    protected $table = 'pictures';

    /**
     * @var array
     */
    protected $fillable = ['horse_id', 'path', 'profile_pic'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function horse()
    {
        return $this->belongsTo(Horse::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function albums()
    {
        return $this->belongsToMany(EloquentAlbum::class, 'album_picture', 'picture_id', 'album_id')->withTimestamps();
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     */
    public function addToAlbum(Album $album)
    {
        $this->albums()->attach($album->id());
    }

    /**
     * @param \EQM\Models\Albums\Album $album
     */
    public function removeFromAlbum(Album $album)
    {
        $this->albums()->detach($album->id());
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
    public function path()
    {
        return $this->path;
    }

    /**
     * @return bool
     */
    public function profilePicture()
    {
        return $this->profile_pic;
    }
}
