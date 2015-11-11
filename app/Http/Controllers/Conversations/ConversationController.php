<?php
namespace EQM\Http\Controllers\Conversations;

use EQM\Http\Controllers\Controller;
use EQM\Models\Conversations\Conversation;
use EQM\Models\Conversations\ConversationRepository;
use EQM\Models\Conversations\MessageRepository;
use EQM\Models\Conversations\Requests\ConversationRequest;
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
        $conversations = $this->conversations->findByUser(auth()->user());

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
     * @param \EQM\Models\Conversations\Requests\ConversationRequest $request
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
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @return \Illuminate\View\View
     */
    public function show(Conversation $conversation)
    {
        $conversation->markAsRead(auth()->user());

        $messages = $this->conversations->findMessages($conversation);

        return view('conversations.show', compact('conversation', 'messages'));
    }

    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Conversation $conversation)
    {
        $conversation->deleteForUser(auth()->user());

        return redirect()->back();
    }
}
