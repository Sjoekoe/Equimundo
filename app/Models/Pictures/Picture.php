<?php 
namespace HorseStories\Models\Pictures;
  
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $table = 'pictures';

    protected $fillable = ['horse_id', 'path', 'profile_pic'];

    public function horse()
    {
        return $this->belongsTo('BeatSwitch\Models\Horses\Horse');
    }
}