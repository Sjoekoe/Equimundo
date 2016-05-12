<?php
namespace EQM\Models\Conversations;

use Carbon\Carbon;
use EQM\Models\Users\EloquentUser;
use EQM\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class EloquentConversation extends Model implements Conversation
{
    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['subject'];

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function subject()
    {
        return $this->subject;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    private function userRelation()
    {
        return $this->belongsToMany(EloquentUser::class, 'conversation_user', 'conversation_id', 'user_id')->withPivot('last_view', 'deleted_at')->withTimestamps();
    }

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function users()
    {
        return $this->userRelation()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesRelation()
    {
        return $this->hasMany(EloquentMessage::class, 'conversation_id', 'id');
    }

    /**
     * @return \EQM\Models\Conversations\Message[]
     */
    public function messages()
    {
        return $this->messagesRelation()->orderBy('created_at', 'ASC')->get();
    }

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function markAsRead(User $user)
    {
        $this->userRelation()->updateExistingPivot($user->id, ['last_view' => Carbon::now()]);
    }

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function markAsUnread(User $user)
    {
        $this->userRelation()->updateExistingPivot($user->id, ['last_view' => null]);
    }

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function deleteForUser(User $user)
    {
        $this->userRelation()->updateExistingPivot($user->id, ['deleted_at' => Carbon::now()]);
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return bool
     */
    public function isDeletedForUser(User $user)
    {
        return $this->pivot->deleted_at !== null;
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return bool
     */
    public function isDeletedForContactPerson(User $user)
    {
        return $this->contactPerson($user)->pivot->deleted_at !== null;
    }

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function unDeleteForContactPerson(User $user)
    {
        $this->userRelation()->updateExistingPivot($this->contactPerson($user)->id, ['deleted_at' => null]);
    }

    /**
     * @param \EQM\Models\Users\User $authenticatedUser
     * @return \EQM\Models\Users\User
     */
    public function contactPerson(User $authenticatedUser)
    {
        foreach ($this->users() as $user) {
            if ($user->id() !== $authenticatedUser->id()) {
                return $user;
            }
        }
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return bool
     */
    public function hasUnreadMessages(User $user)
    {
        foreach ($this->userRelation()->get() as $userRelation) {
            if ($userRelation->id() == $user->id()) {
                return is_null($userRelation->pivot->last_view);
            }
        }

        return false;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt()
    {
        return Carbon::parse($this->updated_at);
    }
}
