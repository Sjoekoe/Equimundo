<?php
namespace EQM\Http\Controllers\Conversations;

use EQM\Http\Controllers\Controller;
use EQM\Models\Conversations\Conversation;
use EQM\Models\Conversations\MessageCreator;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // todo add validation
    public function store(Request $request, MessageCreator $creator, Conversation $conversation)
    {
        $this->authorize('reply-to', $conversation);

        $creator->create($conversation, auth()->user(), $request);

        return redirect()->back();
    }
}
