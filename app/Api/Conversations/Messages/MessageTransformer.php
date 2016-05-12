<?php
namespace EQM\Api\Conversations\Messages;

use EQM\Api\Conversations\ConversationTransformer;
use EQM\Api\Users\UserTransformer;
use EQM\Models\Conversations\Message;
use League\Fractal\TransformerAbstract;

class MessageTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'userRelation',
        'conversationRelation',
    ];

    /**
     * @param \EQM\Models\Conversations\Message $message
     * @return array
     */
    public function transform(Message $message)
    {
        return [
            'id' => $message->id(),
            'body' => $message->body(),
            'made_by_user' => auth()->check() ? $message->user()->id() == auth()->user()->id() : false,
            'created_at' => $message->createdAt()->toIso8601String(),
        ];
    }

    /**
     * @param \EQM\Models\Conversations\Message $message
     * @return \League\Fractal\Resource\Item
     */
    public function includeUserRelation(Message $message)
    {
        return $this->item($message->user(), new UserTransformer());
    }

    /**
     * @param \EQM\Models\Conversations\Message $message
     * @return \League\Fractal\Resource\Item
     */
    public function includeConversationRelation(Message $message)
    {
        return $this->item($message->conversation(), new ConversationTransformer());
    }
}
