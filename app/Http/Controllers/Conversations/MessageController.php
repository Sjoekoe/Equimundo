<?php
namespace EQM\Http\Controllers\Conversations;

use Auth;
use EQM\Http\Controllers\Controller;
use EQM\Models\Conversations\ConversationRepository;
use EQM\Models\Conversations\MessageCreator;
use Input;

class MessageController extends Controller
{
    /**
     * @var \EQM\Models\Conversations\ConversationRepository
     */
    private $conversations;

    /**
     * @var \EQM\Models\Conversations\MessageCreator
     */
    private $creator;

    /**
     * @param \EQM\Models\Conversations\ConversationRepository $conversations
     * @param \EQM\Models\Conversations\MessageCreator $creator
     */
    public function __construct(ConversationRepository $conversations, MessageCreator $creator)
    {
        $this->conversations = $conversations;
        $this->creator = $creator;
    }

    /**
     * @param int $conversationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($conversationId)
    {
        $conversation = $this->conversations->findById($conversationId);

        $this->creator->create($conversation, Auth::user(), Input::all());

        $conversation->setUnread($conversation->contactPerson(Auth::user()));
        if ($conversation->isDeletedForContactPerson(Auth::user())) {
            $conversation->unDeleteForContactPerson(Auth::user());
        }

        return redirect()->back();
    }
}
