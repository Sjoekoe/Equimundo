<?php
namespace HorseStories\Models\Users;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, FollowingTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'first_name',
        'last_name',
        'date_of_birth',
        'country',
        'gender',
        'about'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horses()
    {
        return $this->hasMany('HorseStories\Models\Horses\Horse', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function statuses()
    {
        return $this->hasManyThrough('HorseStories\Models\Statuses\Status', 'Horsestories\Models\Horses\Horse', 'user_id', 'horse_id');
    }
}
