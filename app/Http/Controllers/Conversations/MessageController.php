<?php
namespace HorseStories\Http\Controllers\Conversations;

use Auth;
use HorseStories\Http\Controllers\Controller;
use HorseStories\Models\Conversations\ConversationRepository;
use HorseStories\Models\Conversations\MessageCreator;
use Input;
use Redirect;

class MessageController extends Controller
{
    /**
     * @var \HorseStories\Models\Conversations\ConversationRepository
     */
    private $conversations;

    /**
     * @var \HorseStories\Models\Conversations\MessageCreator
     */
    private $creator;

    /**
     * @param \HorseStories\Models\Conversations\ConversationRepository $conversations
     * @param \HorseStories\Models\Conversations\MessageCreator $creator
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

        return Redirect::back();
    }
}
