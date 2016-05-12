<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\User;

interface Conversation
{
    const TABLE = 'conversations';
    
    /**
     * @return string
     */
    public function id();

    /**
     * @return string
     */
    public function subject();

    /**
     * @return \EQM\Models\Users\User[]
     */
    public function users();

    /**
     * @return \EQM\Models\Conversations\EloquentMessage[]
     */
    public function messages();

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Users\User
     */
    public function contactPerson(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function markAsRead(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function markAsUnread(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function deleteForUser(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     * @return bool
     */
    public function isDeletedForUser(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function isDeletedForContactPerson(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     */
    public function unDeleteForContactPerson(User $user);

    /**
     * @param \EQM\Models\Users\User $user
     * @return bool
     */
    public function hasUnreadMessages(User $user);

    /**
     * @return \Carbon\Carbon
     */
    public function updatedAt();
}
