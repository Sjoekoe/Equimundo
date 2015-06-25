<?php
namespace HorseStories\Models\Conversations;

use HorseStories\Models\Users\User;

class ConversationRepository
{
    /**
     * @param $conversationId
     * @return \HorseStories\Models\Conversations\Conversation
     */
    public function findById($conversationId)
    {
        return Conversation::where('id', $conversationId)->firstOrFail();
    }

    /**
     * @param \HorseStories\Models\Users\User $user
     * @return \HorseStories\Models\Conversations\Conversation[]
     */
    public function findByUser(User $user)
    {
        return Conversation::whereUser('user_id', $user->id)->get();
    }

    /**
     * @param \HorseStories\Models\Conversations\Conversation $conversation
     * @return \HorseStories\Models\Conversations\Message[]
     */
    public function findMessages(Conversation $conversation)
    {
        return Conversation::find($conversation->id)->messages()->orderBy('created_at', 'ASC')->limit(10)->get();
    }
}
