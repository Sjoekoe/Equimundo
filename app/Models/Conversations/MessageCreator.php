<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\User;

class MessageCreator
{
    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @param \EQM\Models\Users\User $user
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
