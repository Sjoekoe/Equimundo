<?php
namespace EQM\Models\Conversations;

class ConversationCreator
{
    /**
     * @param array $values
     * @return \EQM\Models\Conversations\Conversation
     */
    public function create($values)
    {
        $conversation = new Conversation();
        $conversation->subject = $values['subject'];

        $conversation->save();

        return $conversation;
    }
}
