<?php
namespace EQM\Models\Conversations;

use EQM\Http\Requests\Request;
use EQM\Models\Users\User;
use EQM\Models\Users\UserRepository;

class ConversationCreator
{
    /**
     * @var \EQM\Models\Conversations\ConversationRepository
     */
    private $conversations;

    /**
     * @var \EQM\Models\Conversations\MessageRepository
     */
    private $messages;

    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @param \EQM\Models\Conversations\ConversationRepository $conversations
     * @param \EQM\Models\Conversations\MessageRepository $messages
     * @param \EQM\Models\Users\UserRepository $users
     */
    public function __construct(
        ConversationRepository $conversations,
        MessageRepository $messages,
        UserRepository $users
    ) {
        $this->conversations = $conversations;
        $this->messages = $messages;
        $this->users = $users;
    }

    public function create(User $user, Request $request)
    {
        $conversation = $this->conversations->create($request->all());

        $this->messages->create($conversation, $user, $request->all());

        $user->addConversation($conversation);

        $recipientId = $request->get('contact_id');

        $recipient = $this->users->findById($recipientId);

        $recipient->addConversation($conversation);

        return $conversation;
    }
}
