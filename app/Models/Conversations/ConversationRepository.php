<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\User;

interface ConversationRepository
{
    /**
     * @param int $id
     * @return \EQM\Models\Conversations\Conversation
     */
    public function findById($id);

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Conversations\Conversation
     */
    public function findByUser(User $user);

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @return \EQM\Models\Conversations\Conversation
     */
    public function findMessages(Conversation $conversation);

    /**
     * @param array $values
     * @return \EQM\Models\Conversations\Conversation
     */
    public function create($values);
}
