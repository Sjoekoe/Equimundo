<?php
namespace EQM\Api\Http\Controllers\Conversations\Messages;

use EQM\Api\Conversations\Messages\MessageTransformer;
use EQM\Api\Conversations\Messages\Requests\StoreMessageRequest;
use EQM\Api\Http\Controller;
use EQM\Models\Conversations\Conversation;
use EQM\Models\Conversations\MessageCreator;
use EQM\Models\Conversations\MessageRepository;

class MessageController extends Controller
{
    /**
     * @var \EQM\Models\Conversations\MessageRepository
     */
    private $messages;

    public function __construct(MessageRepository $messages)
    {
        $this->messages = $messages;
    }

    public function index(Conversation $conversation)
    {
        auth()->user()->can('read-conversation', $conversation);

        $messages = $this->messages->findByConversationPaginated($conversation);

        return $this->response()->paginator($messages, new MessageTransformer());
    }

    public function store(StoreMessageRequest $request, MessageCreator $creator, Conversation $conversation)
    {
        $message = $creator->create($conversation, auth()->user(), $request);

        return $this->response()->item($message, new MessageTransformer());
    }
}
