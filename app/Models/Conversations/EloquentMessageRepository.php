<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\User;

class EloquentMessageRepository implements MessageRepository
{
    /**
     * @var \EQM\Models\Conversations\EloquentMessage
     */
    private $message;

    /**
     * @param \EQM\Models\Conversations\EloquentMessage $message
     */
    public function __construct(EloquentMessage $message)
    {
        $this->message = $message;
    }

    /**
     * @param int $id
     * @return \EQM\Models\Conversations\Message
     */
    public function findById($id)
    {
        $this->message->where('id', $id)->first();
    }

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @param \EQM\Models\Users\User $user
     * @param array $values
     * @return \EQM\Models\Conversations\Message
     */
    public function create(Conversation $conversation, User $user, $values)
    {
        $message = new EloquentMessage();
        $message->conversation_id = $conversation->id();
        $message->user_id = $user->id();
        $message->body = $values['body'];

        $message->save();

        return $message;
    }

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @param int $limit
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findByConversationPaginated(Conversation $conversation, $limit = 10)
    {
        return $this->message
            ->where('conversation_id', $conversation->id())
            ->latest()
            ->paginate($limit);
    }
}
