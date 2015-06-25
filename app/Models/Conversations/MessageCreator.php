<?php
namespace HorseStories\Models\Conversations;

use HorseStories\Models\Users\User;

class MessageCreator
{
    /**
     * @param \HorseStories\Models\Conversations\Conversation $conversation
     * @param \HorseStories\Models\Users\User $user
     * @param array $values
     */
    public function create(Conversation $conversation, User $user, $values)
    {
        $message = new Message();
        $message->conversation_id = $conversation->id;
        $message->user_id = $user->id;
        $message->body = $values['message'];

        $message->save();
    }
}
