<?php
namespace EQM\Models\Conversations;

use Carbon\Carbon;
use EQM\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class EloquentConversation extends Model implements Conversation
{
    /**
     * @var string
     */
    protected $table = 'conversations';

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
        return $this->belongsToMany(User::class, 'conversation_user', 'conversation_id', 'user_id')->withPivot('last_view', 'deleted_at')->withTimestamps();
    }

    /**
     * @return \EQM\Models\Users\User
     */
    public function user()
    {
        return $this->userRelation()->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(EloquentMessage::class, 'conversation_id', 'id');
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
     * @param \EQM\Models\Users\User $auhtenticatedUser
     * @return \EQM\Models\Users\User
     */
    public function contactPerson(User $auhtenticatedUser)
    {
        foreach ($this->user() as $user) {
            if ($user->id !== $auhtenticatedUser->id) {
                return $user;
            }
        }

        return $auhtenticatedUser;
    }
}
