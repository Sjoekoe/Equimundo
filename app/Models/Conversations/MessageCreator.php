<?php
namespace EQM\Models\Conversations;

use EQM\Models\Users\User;
use Illuminate\Http\Request;

class MessageCreator
{
    /**
     * @var \EQM\Models\Conversations\MessageRepository
     */
    private $messages;

    /**
     * @param \EQM\Models\Conversations\MessageRepository $messages
     */
    public function __construct(MessageRepository $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @param \EQM\Models\Users\User $user
     * @param \Illuminate\Http\Request $request
     */
    public function create(Conversation $conversation, User $user, Request $request)
    {
        $this->messages->create($conversation, $user, $request->all());

        $conversation->markAsUnread($conversation->contactPerson($user));

        if ($conversation->isDeletedForContactPerson($user)) {
            $conversation->unDeleteForContactPerson($user);
        }
    }
}
