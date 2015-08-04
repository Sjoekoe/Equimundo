<?php
namespace EQM\Models\Albums;

use EQM\Models\Horses\Horse;
use EQM\Models\Pictures\Picture;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    const PROFILEPICTURES = 1;
    const COVERPICTURES = 2;
    const TIMELINEPICTURES = 3;

    /**
     * @var array
     */
    protected $fillable = ['name', 'horse_id', 'description', 'type'];

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
    public function pictures()
    {
        return $this->belongsToMany(Picture::class);
    }

    public function setProfileAlbum()
    {
        $this->type = self::PROFILEPICTURES;
    }

    public function setCoverAlbum()
    {
        $this->type = self::COVERPICTURES;
    }

    public function setTimeLineAlbum()
    {
        $this->type = self::TIMELINEPICTURES;
    }
}
