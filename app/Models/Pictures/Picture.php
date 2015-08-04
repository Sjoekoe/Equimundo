<?php
namespace EQM\Models\Pictures;

use EQM\Models\Albums\Album;
use EQM\Models\Horses\Horse;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
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
        return $this->belongsToMany(Album::class, 'album_picture', 'picture_id', 'album_id')->withTimestamps();
    }

    /**
     * @param int $albumId
     */
    public function addToAlbum($albumId)
    {
        $this->albums()->attach($albumId);
    }

    /**
     * @param int $albumId
     */
    public function removeFromAlbum($albumId)
    {
        $this->albums()->detach($albumId);
    }
}
