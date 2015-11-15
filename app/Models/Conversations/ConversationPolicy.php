<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\User;

class ConversationPolicy
{
    /**
     * @param \EQM\Models\Users\User $user
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @return bool
     */
    public function authorize(User $user, Conversation $conversation)
    {
        foreach ($conversation->users() as $conversationUser) {
            if ($conversationUser->id() == $user->id()) {
                return true;
            }
        }

        return false;
    }
}
