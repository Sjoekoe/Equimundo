<?php
namespace HorseStories\Models\Conversations;

class ConversationCreator
{
    /**
     * @param array $values
     * @return \HorseStories\Models\Conversations\Conversation
     */
    public function create($values)
    {
        $conversation = new Conversation();
        $conversation->subject = $values['subject'];

        $conversation->save();

        return $conversation;
    }
}
