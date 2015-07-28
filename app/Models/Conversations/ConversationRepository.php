<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\User;

class ConversationRepository
{
    /**
     * @param $conversationId
     * @return \EQM\Models\Conversations\Conversation
     */
    public function findById($conversationId)
    {
        return Conversation::where('id', $conversationId)->firstOrFail();
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Conversations\Conversation[]
     */
    public function findByUser(User $user)
    {
        return Conversation::whereUser('user_id', $user->id)->get();
    }

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @return \EQM\Models\Conversations\Message[]
     */
    public function findMessages(Conversation $conversation)
    {
        return Conversation::find($conversation->id)->messages()->orderBy('created_at', 'ASC')->limit(10)->get();
    }
}
