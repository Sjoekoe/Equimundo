<?php
namespace EQM\Http\Controllers\Conversations;

use EQM\Http\Controllers\Controller;
use EQM\Models\Conversations\Conversation;
use EQM\Models\Conversations\MessageRepository;
use Input;

class MessageController extends Controller
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Conversation $conversation)
    {
        $this->messages->create($conversation, auth()->user(), Input::all());

        $conversation->markAsUnread($conversation->contactPerson(auth()->user()));

        if ($conversation->isDeletedForContactPerson(auth()->user())) {
            $conversation->unDeleteForContactPerson(auth()->user());
        }

        return redirect()->back();
    }
}
