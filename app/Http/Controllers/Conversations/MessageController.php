<?php
namespace EQM\Http\Controllers\Conversations;

use Auth;
use EQM\Http\Controllers\Controller;
use EQM\Models\Conversations\ConversationRepository;
use EQM\Models\Conversations\MessageRepository;
use Illuminate\Auth\AuthManager;
use Input;

class MessageController extends Controller
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
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    /**
     * @param \EQM\Models\Conversations\ConversationRepository $conversations
     * @param \EQM\Models\Conversations\MessageRepository $messages
     * @param \Illuminate\Auth\AuthManager $auth
     */
    public function __construct(ConversationRepository $conversations, MessageRepository $messages, AuthManager $auth)
    {
        $this->conversations = $conversations;
        $this->messages = $messages;
        $this->auth = $auth;
    }

    /**
     * @param int $conversationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($conversationId)
    {
        $conversation = $this->conversations->findById($conversationId);

        $this->messages->create($conversation, $this->auth->user(), Input::all());

        $conversation->markAsUnread($conversation->contactPerson($this->auth->user()));

        if ($conversation->isDeletedForContactPerson($this->auth->user())) {
            $conversation->unDeleteForContactPerson($this->auth->user());
        }

        return redirect()->back();
    }
}
