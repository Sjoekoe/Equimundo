<?php
namespace HorseStories\Http\Controllers\Conversations;

use Auth;
use HorseStories\Http\Controllers\Controller;
use HorseStories\Http\Requests\ConversationRequest;
use HorseStories\Models\Conversations\ConversationCreator;
use HorseStories\Models\Conversations\ConversationRepository;
use HorseStories\Models\Conversations\MessageCreator;
use HorseStories\Models\Users\UserRepository;
use Input;
use Redirect;

class ConversationController extends Controller
{
    /**
     * @var \HorseStories\Models\Users\UserRepository
     */
    private $users;

    /**
     * @var \HorseStories\Models\Conversations\ConversationCreator
     */
    private $conversationCreator;

    /**
     * @var \HorseStories\Models\Conversations\MessageCreator
     */
    private $messageCreator;

    /**
     * @var \HorseStories\Models\Conversations\ConversationRepository
     */
    private $conversations;

    /**
     * @param \HorseStories\Models\Users\UserRepository $users
     * @param \HorseStories\Models\Conversations\ConversationCreator $conversationCreator
     * @param \HorseStories\Models\Conversations\MessageCreator $messageCreator
     * @param \HorseStories\Models\Conversations\ConversationRepository $conversations
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
            return Redirect::back();
        }

        $owner = $this->users->findById(Input::get('contact'));

        return view('conversations.create', compact('owner'));
    }

    /**
     * @param \HorseStories\Http\Requests\ConversationRequest $request
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

        return Redirect::route('conversation.index');
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

        return Redirect::back();
    }
}
