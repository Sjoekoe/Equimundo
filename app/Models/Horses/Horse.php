<?php 
namespace HorseStories\Models\Horses;
  
use Illuminate\Database\Eloquent\Model;

class Horse extends Model
{
    /**
     * The table name used by the entity
     *
     * @var string
     */
    protected $table = 'horses';

    /**
     * The fillable fields in the database
     *
     * @var array
     */
    protected $fillable = [
        'name', 'gender', 'breed', 'height', 'date_of_birth', 'color', 'life_number', 'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('HorseStories\Models\Users\User', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany('HorseStories\Models\Statuses\Status');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pictures()
    {
        return $this->hasMany('HorseStories\Models\Pictures\Picture');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany('HorseStories\Models\Users\User', 'follows', 'horse_id', 'user_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function palmares()
    {
        return $this->hasMany('HorseStories\Models\Palmares\Palmares');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pedigree()
    {
        return $this->hasMany('HorseStories\Models\Pedigrees\Pedigree');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function family()
    {
        return $this->hasManyThrough('HorseStories\Models\Horses\Horse', 'HorseStories\Models\Pedigrees\Pedigree', 'family_id', 'id');
    }

    /**
     * @return \HorseStories\Models\Pedigrees\Pedigree
     */
    public function father()
    {
        return $this->pedigree->filter(function ($family) {
            return $family->type == 1;
        })->first();
    }

    /**
     * @return \HorseStories\Models\Pedigrees\Pedigree
     */
    public function mother()
    {
        return $this->pedigree->filter(function ($family) {
            return $family->type == 2;
        })->first();
    }

    /**
     * @return \HorseStories\Models\Pedigrees\Pedigree
     */
    public function fathersFather()
    {
        return $this->pedigree->filter(function ($family) {
            return $family->type == 3;
        })->first();
    }

    /**
     * @return \HorseStories\Models\Pedigrees\Pedigree
     */
    public function fathersMother()
    {
        return $this->pedigree->filter(function ($family) {
            return $family->type == 4;
        })->first();
    }

    /**
     * @return \HorseStories\Models\Pedigrees\Pedigree
     */
    public function mothersFather()
    {
        return $this->pedigree->filter(function ($family) {
            return $family->type == 5;
        })->first();
    }

    /**
     * @return \HorseStories\Models\Pedigrees\Pedigree
     */
    public function mothersMother()
    {
        return $this->pedigree->filter(function ($family) {
            return $family->type == 6;
        })->first();
    }

    /**
     * @return \HorseStories\Models\Pictures\Picture
     */
    public function getProfilePicture()
    {
        return $this->pictures->filter(function ($picture) {
            return $picture->profile_pic == true;
        })->first();
    }
}