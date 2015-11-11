<?php
namespace EQM\Models\Users;

use Carbon\Carbon;
use EQM\Models\Comments\EloquentComment;
use EQM\Models\Conversations\EloquentConversation;
use EQM\Models\Events\EloquentEvent;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Horses\Horse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\HorseTeams\HorseTeam;
use EQM\Models\Notifications\EloquentNotification;
use EQM\Models\Roles\Role;
use EQM\Models\Statuses\EloquentStatus;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

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
        'about',
        'remember_token',
        'date_format',
        'email_notifications',
        'language'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function dateOfBirth()
    {
        return Carbon::parse($this->date_of_birth);
    }

    /**
     * @return \EQM\Models\Horses\Horse[]
     */
    public function horses()
    {
        $horses = [];

        foreach ($this->horseTeams() as $team) {
            array_push($horses, $team->horse()->first());
        }

        return $horses;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    private function horseTeamsRelation()
    {
        return $this->hasMany(EloquentHorseTeam::class, 'user_id', 'id');
    }

    /**
     * @return \EQM\Models\HorseTeams\HorseTeam
     */
    public function horseTeams()
    {
        return $this->horseTeamsRelation()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function statuses()
    {
        return $this->hasManyThrough(EloquentStatus::class, EloquentHorse::class, 'user_id', 'horse_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(EloquentComment::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(EloquentStatus::class, 'likes', 'user_id', 'status_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(EloquentEvent::class, 'creator_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function conversations()
    {
        return $this->belongsToMany(EloquentConversation::class, 'conversation_user', 'user_id', 'conversation_id')->withPivot('last_view', 'deleted_at')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(EloquentNotification::class, 'receiver_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follows()
    {
        return $this->belongsToMany(EloquentHorse::class, 'follows', 'user_id', 'horse_id')->withTimestamps();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasRole($name)
    {
        foreach ($this->roles as $role) {
            if ($role->name == $name) return true;
        }

        return false;
    }

    /**
     * @param \EQM\Models\Roles\Role|int $role
     */
    public function assignRole($role)
    {
        return $this->roles()->attach($role);
    }

    /**
     * @param \EQM\Models\Roles\Role|int $role
     * @return int
     */
    public function removeRole($role)
    {
        return $this->roles()->detach($role);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('administrator');
    }

    /**
     * @param \EQM\Models\Conversations\EloquentConversation $conversation
     */
    public function addConversation(EloquentConversation $conversation)
    {
        $this->conversations()->attach($conversation);
    }

    /**
     * @return bool
     */
    public function hasUnreadMessages()
    {
        foreach ($this->conversations as $conversation) {
            if ($conversation->pivot->last_view == null) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return int
     */
    public function countUnreadMessages()
    {
        $count = 0;

        foreach ($this->conversations as $conversation) {
            if ($conversation->pivot->last_view == null) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return bool
     */
    public function isInHorseTeam(Horse $horse)
    {
        foreach ($this->horses() as $userHorse) {
            if ($userHorse->id() == $horse->id()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->language;
    }

    /**
     * @return bool
     */
    public function hasUnreadNotifications()
    {
        return $this->countUnreadNotifications() > 0;
    }

    /**
     * @return int
     */
    public function countUnreadNotifications()
    {
        $count = 0;

        foreach ($this->notifications as $notification) {
            if ($notification->read == false) {
                $count++;
            }
        }

        return $count;
    }

    public function markNotificationsAsRead()
    {
        foreach ($this->notifications as $notification) {
            $notification->markAsRead();
        }
    }

    /**
     * @return string
     */
    public function fullName()
    {
        $name = $this->first_name;

        if ($this->last_name !== null) {
            $name .= ' ' . $this->last_name;
        }

        return $name;
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     */
    public function follow(Horse $horse)
    {
        return $this->follows()->attach($horse);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return int
     */
    public function unFollow(Horse $horse)
    {
        return $this->follows()->detach($horse);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return bool
     */
    public function isFollowing(Horse $horse)
    {
        $followedHorses = $this->follows()->lists('horse_id')->all();

        return in_array($horse->id(), $followedHorses);
    }
}
