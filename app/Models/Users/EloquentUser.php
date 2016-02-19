<?php
namespace EQM\Models\Users;

use Carbon\Carbon;
use EQM\Models\Comments\EloquentComment;
use EQM\Models\Conversations\Conversation;
use EQM\Models\Conversations\EloquentConversation;
use EQM\Models\Events\EloquentEvent;
use EQM\Models\Horses\EloquentHorse;
use EQM\Models\Horses\Horse;
use EQM\Models\HorseTeams\EloquentHorseTeam;
use EQM\Models\Notifications\EloquentNotification;
use EQM\Models\Roles\EloquentRole;
use EQM\Models\Roles\Role;
use EQM\Models\Statuses\EloquentStatus;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

class EloquentUser extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, User
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
        'language',
        'twitter',
        'facebook',
        'website',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @return Carbon|null
     */
    public function dateOfBirth()
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth) : null;
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function commentLikes()
    {
        return $this->belongsToMany(EloquentComment::class, 'comment_likes', 'user_id', 'comment_id')->withTimestamps();
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
        return $this->hasMany(EloquentRole::class, 'user_id', 'id')->get();
    }

    /**
     * @return \EQM\Models\Conversations\Conversation[]
     */
    public function conversations()
    {
        return $this->conversationRelation()->latest()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    private function conversationRelation()
    {
        return $this->belongsToMany(EloquentConversation::class, 'conversation_user', 'user_id', 'conversation_id')
            ->withPivot('last_view', 'deleted_at')
            ->withTimestamps();
    }

    /**
     * @return \EQM\Models\Notifications\Notification
     */
    public function notifications()
    {
        return $this->hasMany(EloquentNotification::class, 'receiver_id', 'id')->latest()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    private function followRelation()
    {
        return $this->belongsToMany(EloquentHorse::class, 'follows', 'user_id', 'horse_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function follows()
    {
        // todo make a relation for the attach methods
        return $this->followRelation()->get();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasRole($name)
    {
        foreach ($this->roles() as $role) {
            if ($role->name() == $name) return true;
        }

        return false;
    }

    /**
     * @param \EQM\Models\Roles\Role $role
     */
    public function assignRole(Role $role)
    {
        return $this->roles()->attach($role);
    }

    /**
     * @param \EQM\Models\Roles\Role $role
     * @return int
     */
    public function removeRole(Role $role)
    {
        return $this->roles()->detach($role);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole(Role::ADMIN);
    }

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     */
    public function addConversation(Conversation $conversation)
    {
        $this->conversationRelation()->attach($conversation->id());
    }

    /**
     * @return bool
     */
    public function hasUnreadMessages()
    {
        foreach ($this->conversations() as $conversation) {
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

        foreach ($this->conversations() as $conversation) {
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

        foreach ($this->notifications() as $notification) {
            if ($notification->isRead() == false) {
                $count++;
            }
        }

        return $count;
    }

    public function markNotificationsAsRead()
    {
        foreach ($this->notifications() as $notification) {
            $notification->markAsRead();
        }
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return $this->firstName() . ' ' . $this->lastName();
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     */
    public function follow(Horse $horse)
    {
        return $this->followRelation()->attach($horse);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return int
     */
    public function unFollow(Horse $horse)
    {
        return $this->followRelation()->detach($horse);
    }

    /**
     * @param \EQM\Models\Horses\Horse $horse
     * @return bool
     */
    public function isFollowing(Horse $horse)
    {
        foreach ($this->follows() as $follow) {
            if ($horse->id() == $follow->id()) {
                return true;
            }
        }

        return false;
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
    public function email()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function firstName()
    {
        return $this->first_name;
    }

    /**
     * @return string
     */
    public function lastName()
    {
        return $this->last_name;
    }

    /**
     * @return string
     */
    public function country()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function gender()
    {
        return $this->gender;
    }

    /**
     * @return string
     */
    public function about()
    {
        return $this->about;
    }

    /**
     * @return string
     */
    public function rememberToken()
    {
        return $this->remember_token;
    }

    /**
     * @return string
     */
    public function dateFormat()
    {
        return $this->date_format;
    }

    /**
     * @return bool
     */
    public function emailNotifications()
    {
        return $this->email_notifications;
    }

    /**
     * @return string
     */
    public function language()
    {
        return $this->language;
    }

    /**
     * @return bool
     */
    public function activated()
    {
        return $this->activated;
    }

    /**
     * @return string
     */
    public function facebook()
    {
        return $this->facebook;
    }

    /**
     * @return string
     */
    public function twitter()
    {
        return $this->twitter;
    }

    /**
     * @return string
     */
    public function website()
    {
        return $this->website;
    }
}
