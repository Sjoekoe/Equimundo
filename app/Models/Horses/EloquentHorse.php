<?php
namespace EQM\Models\Horses;

use Carbon\Carbon;
use EQM\Models\Albums\EloquentAlbum;
use EQM\Models\Disciplines\EloquentDiscipline;
use EQM\Models\Palmares\EloquentPalmares;
use EQM\Models\Pedigrees\Pedigree;
use EQM\Models\Pictures\EloquentPicture;
use EQM\Models\Statuses\EloquentStatus;
use EQM\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class EloquentHorse extends Model implements Horse
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
     * @return int
     */
    public function gender()
    {
        return $this->gender;
    }

    /**
     * @return int
     */
    public function breed()
    {
        return $this->breed;
    }

    /**
     * @return string
     */
    public function height()
    {
        return $this->height;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function dateOfBirth()
    {
        return Carbon::instance($this->date_of_birth);
    }

    /**
     * @return int
     */
    public function color()
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function lifeNumber()
    {
        return $this->life_number;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return bool
     */
    public function hasOwner()
    {
        return $this->user_id !== null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(EloquentStatus::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pictures()
    {
        return $this->hasMany(EloquentPicture::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'horse_id', 'user_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function palmares()
    {
        return $this->hasMany(EloquentPalmares::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pedigree()
    {
        return $this->hasMany(Pedigree::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function family()
    {
        return $this->hasManyThrough(EloquentHorse::class, Pedigree::class, 'family_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function disciplines()
    {
        return $this->hasMany(EloquentDiscipline::class, 'horse_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albums()
    {
        return $this->hasMany(EloquentAlbum::class);
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function father()
    {
        $pedigree =  $this->pedigree->filter(function ($family) {
            return $family->type == 1;
        })->first();

        return $pedigree ? $pedigree->originalHorse : null;
    }

    /**
     * @return bool
     */
    public function hasFather()
    {
        return $this->father() !== null;
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function fathersFather()
    {
        return $this->father()->father();
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function fathersMother()
    {
        return $this->father()->mother();
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function mother()
    {
        $pedigree =  $this->pedigree->filter(function ($family) {
            return $family->type == 2;
        })->first();

        return $pedigree ? $pedigree->originalHorse : null;
    }

    /**
     * @return bool
     */
    public function hasMother()
    {
        return $this->mother() !== null;
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function mothersFather()
    {
        return $this->mother()->father();
    }

    /**
     * @return \EQM\Models\Horses\EloquentHorse
     */
    public function mothersMother()
    {
        return $this->mother()->mother();
    }

    /**
     * @return \EQM\Models\Pictures\Picture
     */
    public function getProfilePicture()
    {
        return $this->pictures->filter(function ($picture) {
            return $picture->profile_pic == true;
        })->first();
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getBirthDay()
    {
        return Carbon::instance($this->date_of_birth)->format('d/m/Y');
    }

    /**
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function sons()
    {
        return $this->pedigree->filter(function($family) {
            return $family->type == 3;
        })->all();
    }

    /**
     * @return \EQM\Models\Pedigrees\Pedigree
     */
    public function daughters()
    {
        return $this->pedigree->filter(function($family) {
            return $family->type == 4;
        })->all();
    }

    /**
     * @param int $disciplineId
     * @return bool
     */
    public function performsDiscipline($disciplineId)
    {
        return $this->disciplines->filter(function($discipline) use ($disciplineId) {
           return $discipline->discipline === $disciplineId;
        })->first();
    }

    /**
     * @return bool
     */
    public function isFemale()
    {
        return $this->gender == self::FEMALE;
    }

    /**
     * @param int $type
     * @return \EQM\Models\Albums\Album
     */
    public function getStandardAlbum($type)
    {
        foreach($this->albums as $album) {
            if ($album->type == $type) {
                return $album;
            }
        }
    }
}
