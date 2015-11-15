<?php
namespace EQM\Http\Controllers\Conversations;

use EQM\Http\Controllers\Controller;
use EQM\Http\Requests\Request;
use EQM\Models\Conversations\Conversation;
use EQM\Models\Conversations\ConversationCreator;
use EQM\Models\Conversations\ConversationRepository;
use EQM\Models\Conversations\Requests\ConversationRequest;
use EQM\Models\Users\UserRepository;

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

    public function __construct(
        UserRepository $users,
        ConversationRepository $conversations
    ) {
        $this->users = $users;
        $this->conversations = $conversations;
    }

    public function index()
    {
        return view('conversations.index');
    }

    public function create(Request $request)
    {
        if (! $request->has('contact')) {
            return redirect()->back();
        }

        $owner = $this->users->findById($request->get('contact'));

        return view('conversations.create', compact('owner'));
    }

    public function store(ConversationRequest $request, ConversationCreator $creator)
    {
        $creator->create(auth()->user(), $request);

        session()->put('success', 'Message sent');

        return redirect()->route('conversation.index');
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('read-conversation', $conversation);

        $conversation->markAsRead(auth()->user());

        $messages = $this->conversations->findMessages($conversation);

        return view('conversations.show', compact('conversation', 'messages'));
    }

    public function delete(Conversation $conversation)
    {
        $this->authorize('delete-conversation', $conversation);

        $conversation->deleteForUser(auth()->user());

        return redirect()->back();
    }
}
