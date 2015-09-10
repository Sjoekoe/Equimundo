<?php
namespace EQM\Models\Users;

use EQM\Events\Event;
use EQM\Models\Comments\EloquentComment;
use EQM\Models\Conversations\EloquentConversation;
use EQM\Models\Horses\Horse;
use EQM\Models\Notifications\EloquentNotification;
use EQM\Models\Roles\Role;
use EQM\Models\Settings\Setting;
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
    use Authenticatable, Authorizable, CanResetPassword, FollowingTrait;

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
        'remember_token'
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
        return $this->hasMany(Horse::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function statuses()
    {
        return $this->hasManyThrough(EloquentStatus::class, Horse::class, 'user_id', 'horse_id');
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
        return $this->hasMany(Event::class, 'creator_id', 'id');
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function settings()
    {
        return $this->hasOne(Setting::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(EloquentNotification::class, 'receiver_id', 'id');
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
        return $this->hasRole('administrator') ? true : false;
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
    public function isHorseOwner(Horse $horse)
    {
        return $this->id == $horse->owner->id;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->settings->language ?: 'en';
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
}
