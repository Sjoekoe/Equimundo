<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\User;

class EloquentConversationRepository implements ConversationRepository
{
    /**
     * @var \EQM\Models\Conversations\EloquentConversation
     */
    private $conversation;

    /**
     * @param \EQM\Models\Conversations\EloquentConversation $conversation
     */
    public function __construct(EloquentConversation $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * @param $conversationId
     * @return \EQM\Models\Conversations\EloquentConversation
     */
    public function findById($conversationId)
    {
        return $this->conversation->where('id', $conversationId)->firstOrFail();
    }

    /**
     * @param \EQM\Models\Users\User $user
     * @return \EQM\Models\Conversations\EloquentConversation[]
     */
    public function findByUser(User $user)
    {
        return $this->conversation
            ->join('conversation_user', 'conversations.id', '=', 'conversation_user.conversation_id')
            ->where('conversation_user.user_id', $user->id())->get();
    }

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @return \EQM\Models\Conversations\EloquentMessage[]
     */
    public function findMessages(Conversation $conversation)
    {
        return $this->conversation->find($conversation->id())->messages()->orderBy('created_at', 'DESC')->limit(10)->get();
    }

    /**
     * @param array $values
     * @return \EQM\Models\Conversations\Conversation
     */
    public function create($values)
    {
        $conversation = new EloquentConversation();
        $conversation->subject = $values['subject'];

        $conversation->save();

        return $conversation;
    }
}
