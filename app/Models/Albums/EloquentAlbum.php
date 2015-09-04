<?php
namespace EQM\Models\Albums;

use EQM\Models\Horses\Horse;
use EQM\Models\Pictures\Picture;
use Illuminate\Database\Eloquent\Model;

class EloquentAlbum extends Model implements Album
{
    /**
     * @var string
     */
    protected $table = 'albums';

    /**
     * @var array
     */
    protected $fillable = ['name', 'horse_id', 'description', 'type'];

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
    public function name()
    {
        return $this->name;
    }

    /**
     * @return \EQM\Models\Horses\Horse
     */
    public function horse()
    {
        return $this->belongsTo(Horse::class, 'horse_id', 'id')->first();
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * @return \EQM\Models\Pictures\Picture[]
     */
    public function pictures()
    {
        return $this->belongsToMany(Picture::class, 'album_picture', 'album_id', 'id')->get();
    }
}
