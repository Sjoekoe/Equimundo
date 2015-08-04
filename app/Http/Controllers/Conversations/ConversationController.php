<?php
namespace EQM\Http\Controllers\Conversations;

use Auth;
use EQM\Http\Controllers\Controller;
use EQM\Http\Requests\ConversationRequest;
use EQM\Models\Conversations\ConversationCreator;
use EQM\Models\Conversations\ConversationRepository;
use EQM\Models\Conversations\MessageCreator;
use EQM\Models\Users\UserRepository;
use Input;

class ConversationController extends Controller
{
    /**
     * @var \EQM\Models\Users\UserRepository
     */
    private $users;

    /**
     * @var \EQM\Models\Conversations\ConversationCreator
     */
    private $conversationCreator;

    /**
     * @var \EQM\Models\Conversations\MessageCreator
     */
    private $messageCreator;

    /**
     * @var \EQM\Models\Conversations\ConversationRepository
     */
    private $conversations;

    /**
     * @param \EQM\Models\Users\UserRepository $users
     * @param \EQM\Models\Conversations\ConversationCreator $conversationCreator
     * @param \EQM\Models\Conversations\MessageCreator $messageCreator
     * @param \EQM\Models\Conversations\ConversationRepository $conversations
     */
    public function __construct(
        UserRepository $users,
        ConversationCreator $conversationCreator,
        MessageCreator $messageCreator,
        ConversationRepository $conversations
    ) {
        $this->users = $users;
        $this->conversationCreator = $conversationCreator;
        $this->messageCreator = $messageCreator;
        $this->conversations = $conversations;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $conversations = $this->users->findConversations(Auth::user());

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
        $conversation = $this->conversationCreator->create($request->all());

        $this->messageCreator->create($conversation, Auth::user(), $request->all());

        Auth::user()->addConversation($conversation);

        $recipientId = $request->get('contact_id');

        $recipient = $this->users->findById($recipientId);

        $recipient->addConversation($conversation);

        return redirect()->route('conversation.index');
    }

    public function show($conversationId)
    {
        $conversation = $this->conversations->findById($conversationId);

        $conversation->setRead(Auth::user());

        $messages = $this->conversations->findMessages($conversation);

        return view('conversations.show', compact('conversation', 'messages'));
    }

    public function delete($conversationId)
    {
        $conversation = $this->conversations->findById($conversationId);

        $conversation->deleteForUser(Auth::user());

        return redirect()->back();
    }
}
