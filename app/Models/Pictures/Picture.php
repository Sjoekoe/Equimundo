<?php
namespace EQM\Models\Pictures;

use EQM\Models\Albums\Album;
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
        return $this->belongsTo('BeatSwitch\Models\Horses\Horse');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function albums()
    {
        return $this->belongsToMany(Album::class, 'album_picture', 'picture_id', 'album_id');
    }
}
