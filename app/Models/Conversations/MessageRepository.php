<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\User;

interface MessageRepository
{
    /**
     * @param int $id
     * @return \EQM\Models\Conversations\Message
     */
    public function findById($id);

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Conversations\Message
     */
    public function create(Conversation $conversation, User $user, $values);

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findByConversationPaginated(Conversation $conversation, $limit = 10);
}
