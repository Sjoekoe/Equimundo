<?php
namespace EQM\Api\Conversations;

use EQM\Models\Conversations\Conversation;
use League\Fractal\TransformerAbstract;

class ConversationTransformer extends TransformerAbstract
{
    /**
     * @param \EQM\Models\Conversations\Conversation $conversation
     * @return array
     */
    public function transform(Conversation $conversation)
    {
        return [
            'id' => $conversation->id(),
            'subject' => $conversation->subject(),
            'updated_at' => $conversation->updatedAt()->toIso8601String(),
        ];
    }
}
