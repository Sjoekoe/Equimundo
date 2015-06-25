<?php
namespace HorseStories\Models\Conversations;

use Carbon\Carbon;
use HorseStories\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['subject'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'conversation_user')->withPivot('last_view', 'deleted_at')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     */
    public function setRead(User $user)
    {
        $this->user()->updateExistingPivot($user->id, ['last_view' => Carbon::now()]);
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     */
    public function setUnread(User $user)
    {
        $this->user()->updateExistingPivot($user->id, ['last_view' => null]);
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     */
    public function deleteForUser(User $user)
    {
        $this->user()->updateExistingPivot($user->id, ['deleted_at' => Carbon::now()]);
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return bool
     */
    public function isDeletedForContactPerson(User $user)
    {
        return $this->contactPerson($user)->pivot->deleted_at !== null;
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     */
    public function unDeleteForContactPerson(User $user)
    {
        $this->user()->updateExistingPivot($this->contactPerson($user)->id, ['deleted_at' => null]);
    }

    /**
     * @param \HorseStories\Models\Users\User $auhtenticatedUser
     * @return \HorseStories\Models\Users\User
     */
    public function contactPerson(User $auhtenticatedUser)
    {
        foreach ($this->user as $user) {
            if ($user->id !== $auhtenticatedUser->id) {
                return $user;
            }
        }
    }
}
