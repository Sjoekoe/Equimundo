<?php
namespace EQM\Http\Controllers\Conversations;

use EQM\Http\Controllers\Controller;
use EQM\Http\Requests\ConversationRequest;
use EQM\Models\Conversations\ConversationRepository;
use EQM\Models\Conversations\MessageRepository;
use EQM\Models\Users\UserRepository;
use Input;

class ConversationController extends Controller
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @var \EQM\Models\Conversations\ConversationRepository
     */
    private $conversations;

    /**
     * @var \EQM\Models\Conversations\MessageRepository
     */
    private $messages;

    /**
     * @param \EQM\Models\Users\UserRepository $users
     * @param \EQM\Models\Conversations\ConversationRepository $conversations
     * @param \EQM\Models\Conversations\MessageRepository $messages
     */
    public function __construct(
        UserRepository $users,
        ConversationRepository $conversations,
        MessageRepository $messages
    ) {
        $this->users = $users;
        $this->conversations = $conversations;
        $this->messages = $messages;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $conversations = $this->users->findConversations(auth()->user());

        return view('conversations.index', compact('conversations'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (! Input::has('contact')) {
            return redirect()->back();
        }

        $owner = $this->users->findById(Input::get('contact'));

        return view('conversations.create', compact('owner'));
    }

    /**
     * @param \EQM\Http\Requests\ConversationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ConversationRequest $request)
    {
        $conversation = $this->conversations->create($request->all());

        $this->messages->create($conversation, auth()->user(), $request->all());

        auth()->user()->addConversation($conversation);

        $recipientId = $request->get('contact_id');

        $recipient = $this->users->findById($recipientId);

        $recipient->addConversation($conversation);

        return redirect()->route('conversation.index');
    }

    /**
     * @param int $conversationId
     * @return \Illuminate\View\View
     */
    public function show($conversationId)
    {
        $conversation = $this->conversations->findById($conversationId);

        $conversation->markAsRead(auth()->user());

        $messages = $this->conversations->findMessages($conversation);

        return view('conversations.show', compact('conversation', 'messages'));
    }

    /**
     * @param int $conversationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($conversationId)
    {
        $conversation = $this->conversations->findById($conversationId);

        $conversation->deleteForUser(auth()->user());

        return redirect()->back();
    }
}
